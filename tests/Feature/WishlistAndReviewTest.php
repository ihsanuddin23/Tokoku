<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistAndReviewTest extends TestCase
{
    use RefreshDatabase;

    private function setupData(): array
    {
        $buyer = User::factory()->buyer()->create();
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id, 'is_active' => true]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 20,
            'status' => 'active',
        ]);

        return [$buyer, $product, $sellerProfile, $category];
    }

    private function createCompletedOrder(User $buyer, Product $product): Order
    {
        $address = Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'postal_code' => '12190',
            'full_address' => 'Jl. Test No. 123',
            'is_default' => true,
        ]);

        $order = $buyer->orders()->create(['address_id' => $address->id]);
        $order->forceFill([
            'order_number' => 'ORD-TEST' . rand(1000, 9999),
            'status' => 'completed',
            'subtotal' => $product->price,
            'shipping_cost' => 15000,
            'grand_total' => $product->price + 15000,
            'payment_method' => 'midtrans',
            'payment_status' => 'paid',
            'shipping_address' => 'Test Address',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
            'paid_at' => now()->subDays(5),
            'shipped_at' => now()->subDays(3),
            'completed_at' => now()->subDays(1),
        ])->save();

        (new OrderItem)->forceFill([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_profile_id' => $product->seller_profile_id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
            'status' => 'completed',
        ])->save();

        return $order;
    }

    // === WISHLIST TESTS ===

    public function test_buyer_can_view_wishlist(): void
    {
        [$buyer] = $this->setupData();

        $response = $this->actingAs($buyer)->get('/wishlist');

        $response->assertStatus(200);
        $response->assertViewIs('wishlist.index');
    }

    public function test_buyer_can_add_product_to_wishlist(): void
    {
        [$buyer, $product] = $this->setupData();

        $response = $this->actingAs($buyer)->post("/wishlist/{$product->id}/toggle");

        $response->assertRedirect();
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_buyer_can_remove_product_from_wishlist(): void
    {
        [$buyer, $product] = $this->setupData();

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $response = $this->actingAs($buyer)->post("/wishlist/{$product->id}/toggle");

        $response->assertRedirect();
        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_wishlist_toggle_returns_json_when_requested(): void
    {
        [$buyer, $product] = $this->setupData();

        $response = $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->post("/wishlist/{$product->id}/toggle");

        $response->assertJson([
            'wishlisted' => true,
        ]);
    }

    public function test_guest_cannot_access_wishlist(): void
    {
        $response = $this->get('/wishlist');

        $response->assertRedirect(route('login'));
    }

    // === REVIEW TESTS ===

    public function test_buyer_can_submit_review_for_completed_order(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 5, 'comment' => 'Great product!'],
            ],
        ]);

        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => 5,
        ]);
    }

    public function test_review_updates_product_rating(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        $this->actingAs($buyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 4, 'comment' => 'Good'],
            ],
        ]);

        $product->refresh();
        $this->assertEquals(4.0, (float) $product->rating);
        $this->assertEquals(1, $product->review_count);
    }

    public function test_buyer_cannot_review_non_completed_order(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);
        $order->forceFill(['status' => 'shipped'])->save();

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 5, 'comment' => 'Good'],
            ],
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseMissing('product_reviews', [
            'order_id' => $order->id,
        ]);
    }

    public function test_buyer_cannot_review_twice_for_same_order(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        ProductReview::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => 5,
            'comment' => 'First review',
        ]);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 3, 'comment' => 'Second review'],
            ],
        ]);

        $this->assertEquals(1, ProductReview::where('order_id', $order->id)->count());
        $this->assertEquals(5, ProductReview::where('order_id', $order->id)->first()->rating);
    }

    public function test_review_validation_requires_rating(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 0],
            ],
        ]);

        $response->assertSessionHasErrors(['reviews.0.rating']);
    }

    public function test_other_user_cannot_review_order(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);
        $otherBuyer = User::factory()->buyer()->create();

        $response = $this->actingAs($otherBuyer)->post("/orders/{$order->id}/reviews", [
            'reviews' => [
                ['product_id' => $product->id, 'rating' => 5],
            ],
        ]);

        $response->assertStatus(403);
    }

    // === REORDER TESTS ===

    public function test_buyer_can_reorder_completed_order(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reorder");

        $response->assertRedirect(route('cart'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_reorder_skips_out_of_stock_products(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);
        $product->update(['stock' => 0]);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reorder");

        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_reorder_merges_with_existing_cart(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->actingAs($buyer)->post("/orders/{$order->id}/reorder");

        $cart = $buyer->cartItems()->where('product_id', $product->id)->first();
        $this->assertEquals(4, $cart->quantity); // 3 existing + 1 from order
    }

    public function test_other_user_cannot_reorder(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);
        $otherBuyer = User::factory()->buyer()->create();

        $response = $this->actingAs($otherBuyer)->post("/orders/{$order->id}/reorder");

        $response->assertStatus(403);
    }

    // === PRODUCT SHOW PAGE TESTS ===

    public function test_product_show_displays_reviews(): void
    {
        [$buyer, $product] = $this->setupData();
        $order = $this->createCompletedOrder($buyer, $product);

        ProductReview::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => 5,
            'comment' => 'Excellent!',
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee('Excellent!');
        $response->assertSee('★');
    }

    public function test_product_show_displays_wishlist_button_for_authenticated_user(): void
    {
        [$buyer, $product] = $this->setupData();

        $response = $this->actingAs($buyer)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee(route('wishlist.toggle', $product));
    }

    public function test_product_show_displays_related_products(): void
    {
        [, $product] = $this->setupData();
        $sellerProfile = $product->sellerProfile;
        $category = $product->category;

        $related = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'active',
            'total_sold' => 50,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee($related->name);
        $response->assertSee('Produk Serupa');
    }
}
