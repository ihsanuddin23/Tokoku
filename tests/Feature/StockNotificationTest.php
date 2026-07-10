<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SellerProfile;
use App\Models\StockSubscription;
use App\Models\User;
use App\Notifications\StockAvailableNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class StockNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private SellerProfile $sellerProfile;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Models\Category::factory()->create(['is_active' => true]);
        $this->buyer = User::factory()->buyer()->create();
        $this->seller = User::factory()->seller()->create();
        $this->sellerProfile = SellerProfile::factory()->create(['user_id' => $this->seller->id]);
    }

    public function test_buyer_can_subscribe_to_out_of_stock_product(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $this->actingAs($this->buyer)
            ->post(route('products.notify-stock', $product))
            ->assertRedirect();

        $this->assertDatabaseHas('stock_subscriptions', [
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
            'product_variant_id' => null,
            'notified' => false,
        ]);
    }

    public function test_guest_cannot_subscribe_to_stock(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $this->post(route('products.notify-stock', $product))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_cannot_subscribe_twice_to_same_product(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($this->buyer)
            ->post(route('products.notify-stock', $product))
            ->assertSessionHas('info');
    }

    public function test_buyer_can_subscribe_to_specific_variant(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Red XL',
            'price_adjustment' => 0,
            'stock' => 0,
            'is_active' => true,
        ]);

        $this->actingAs($this->buyer)
            ->post(route('products.notify-stock', $product), [
                'product_variant_id' => $variant->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('stock_subscriptions', [
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'notified' => false,
        ]);
    }

    public function test_stock_subscription_validates_variant_exists(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $this->actingAs($this->buyer)
            ->post(route('products.notify-stock', $product), [
                'product_variant_id' => 99999,
            ])
            ->assertSessionHasErrors(['product_variant_id']);
    }

    public function test_subscribe_returns_json_when_requested(): void
    {
        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $this->actingAs($this->buyer)
            ->postJson(route('products.notify-stock', $product))
            ->assertOk()
            ->assertJson(['message' => 'Anda akan diberi tahu saat stok tersedia.']);
    }

    public function test_subscribe_inactive_product_returns_404(): void
    {
        $product = Product::factory()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'inactive',
            'stock' => 0,
        ]);

        $this->actingAs($this->buyer)
            ->post(route('products.notify-stock', $product))
            ->assertNotFound();
    }

    public function test_notification_sent_when_product_restocked(): void
    {
        Notification::fake();

        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
        ]);

        $service = app(\App\Services\StockNotificationService::class);
        $product->update(['stock' => 10]);
        $service->notifyProductRestocked($product->fresh());

        Notification::assertSentTo($this->buyer, StockAvailableNotification::class);

        $this->assertDatabaseHas('stock_subscriptions', [
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
            'notified' => true,
        ]);
    }

    public function test_notification_not_sent_when_stock_still_zero(): void
    {
        Notification::fake();

        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
        ]);

        $service = app(\App\Services\StockNotificationService::class);
        $service->notifyProductRestocked($product);

        Notification::assertNotSentTo($this->buyer, StockAvailableNotification::class);
    }

    public function test_notification_sent_only_to_unnotified_subscribers(): void
    {
        Notification::fake();

        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $buyer2 = User::factory()->buyer()->create();

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
            'notified' => true,
        ]);

        StockSubscription::create([
            'user_id' => $buyer2->id,
            'product_id' => $product->id,
            'notified' => false,
        ]);

        $service = app(\App\Services\StockNotificationService::class);
        $product->update(['stock' => 5]);
        $service->notifyProductRestocked($product->fresh());

        Notification::assertNotSentTo($this->buyer, StockAvailableNotification::class);
        Notification::assertSentTo($buyer2, StockAvailableNotification::class);
    }

    public function test_variant_notification_sent_when_restocked(): void
    {
        Notification::fake();

        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Red XL',
            'price_adjustment' => 0,
            'stock' => 0,
            'is_active' => true,
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
        ]);

        $service = app(\App\Services\StockNotificationService::class);
        $variant->update(['stock' => 5]);
        $service->notifyVariantRestocked($variant->id, 5);

        Notification::assertSentTo($this->buyer, StockAvailableNotification::class);

        $this->assertDatabaseHas('stock_subscriptions', [
            'user_id' => $this->buyer->id,
            'product_variant_id' => $variant->id,
            'notified' => true,
        ]);
    }

    public function test_stock_updated_event_triggers_notification_on_restock(): void
    {
        Notification::fake();

        $product = Product::factory()->outOfStock()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
        ]);

        $oldStock = 0;
        $newStock = 10;
        $product->update(['stock' => $newStock]);
        $product->refresh();

        event(new \App\Events\StockUpdated($product, $oldStock, $newStock));

        Notification::assertSentTo($this->buyer, StockAvailableNotification::class);
    }

    public function test_stock_updated_event_does_not_trigger_when_not_restocked(): void
    {
        Notification::fake();

        $product = Product::factory()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
            'stock' => 5,
        ]);

        StockSubscription::create([
            'user_id' => $this->buyer->id,
            'product_id' => $product->id,
        ]);

        event(new \App\Events\StockUpdated($product, 5, 10));

        Notification::assertNotSentTo($this->buyer, StockAvailableNotification::class);
    }
}
