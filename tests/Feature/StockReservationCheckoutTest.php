<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\StockReservation;
use App\Models\User;
use App\Services\StockReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockReservationCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function setupData(): array
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 5,
            'status' => 'active',
        ]);

        $buyer = User::factory()->buyer()->create();
        Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '08123456789',
            'full_address' => 'Jl. Test No. 1',
            'district' => 'Test',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
            'is_default' => true,
        ]);

        return [$buyer, $seller, $sellerProfile, $product, $category];
    }

    public function test_checkout_page_reserves_stock(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(2, $product->stock);
        $this->assertDatabaseHas('stock_reservations', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_completing_order_consumes_reservation(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        // Visit checkout to reserve stock
        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(2, $product->stock);

        // Submit order
        $response = $this->actingAs($buyer)->post('/orders', [
            'address_id' => $buyer->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('orders.show', 1));

        $product->refresh();
        $this->assertEquals(2, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
        $this->assertDatabaseEmpty('carts');
    }

    public function test_cancel_checkout_releases_stock(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        // Visit checkout to reserve stock
        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(2, $product->stock);

        // Cancel checkout
        $response = $this->actingAs($buyer)
            ->post(route('orders.cancel-checkout'));

        $response->assertRedirect(route('cart'));

        $product->refresh();
        $this->assertEquals(5, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
    }

    public function test_expired_reservation_releases_stock_via_command(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        // Reserve stock
        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(2, $product->stock);

        // Manually expire the reservation
        StockReservation::where('user_id', $buyer->id)->update([
            'expires_at' => now()->subMinute(),
        ]);

        // Run the command
        $this->artisan('reservations:release-expired')
            ->assertSuccessful()
            ->expectsOutputToContain('Released');

        $product->refresh();
        $this->assertEquals(5, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
    }

    public function test_reentering_checkout_releases_old_reservation_and_creates_new(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // First checkout visit
        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(3, $product->stock);
        $this->assertCount(1, StockReservation::where('user_id', $buyer->id)->get());

        // Second checkout visit (should release old and create new)
        $this->actingAs($buyer)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(3, $product->stock);
        $this->assertCount(1, StockReservation::where('user_id', $buyer->id)->get());
    }

    public function test_insufficient_stock_redirects_from_checkout(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

        $response = $this->actingAs($buyer)->get('/orders/create');

        $response->assertRedirect(route('cart'));
        $response->assertSessionHas('info');

        $product->refresh();
        $this->assertEquals(5, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
    }

    public function test_two_users_checkout_same_product_second_gets_remaining_stock(): void
    {
        [$buyer1, , , $product] = $this->setupData();
        $buyer2 = User::factory()->buyer()->create();
        Address::create([
            'user_id' => $buyer2->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer2->name,
            'phone' => '08123456789',
            'full_address' => 'Jl. Test No. 2',
            'district' => 'Test',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
            'is_default' => true,
        ]);

        // Buyer 1 adds 3 items
        $buyer1->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        // Buyer 2 adds 2 items (only 2 remaining after buyer 1 reserves 3)
        $buyer2->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Buyer 1 visits checkout — reserves 3
        $this->actingAs($buyer1)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(2, $product->stock);

        // Buyer 2 visits checkout — reserves remaining 2
        $this->actingAs($buyer2)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(0, $product->stock);

        // Buyer 1 completes order
        $this->actingAs($buyer1)->post('/orders', [
            'address_id' => $buyer1->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        // Buyer 2 completes order
        $this->actingAs($buyer2)->post('/orders', [
            'address_id' => $buyer2->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $product->refresh();
        $this->assertEquals(0, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
    }

    public function test_reservation_expires_and_stock_restored_then_other_user_can_buy(): void
    {
        [$buyer1, , , $product] = $this->setupData();
        $buyer2 = User::factory()->buyer()->create();
        Address::create([
            'user_id' => $buyer2->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer2->name,
            'phone' => '08123456789',
            'full_address' => 'Jl. Test No. 2',
            'district' => 'Test',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
            'is_default' => true,
        ]);

        // Buyer 1 adds 4 items and visits checkout
        $buyer1->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 4,
        ]);

        $this->actingAs($buyer1)->get('/orders/create')->assertOk();

        $product->refresh();
        $this->assertEquals(1, $product->stock);

        // Buyer 2 tries to add 4 items — only 1 in stock
        $buyer2->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 4,
        ]);

        // Buyer 2 visits checkout — insufficient stock
        $response = $this->actingAs($buyer2)->get('/orders/create');
        $response->assertRedirect(route('cart'));

        // Buyer 1's reservation expires
        StockReservation::where('user_id', $buyer1->id)->update([
            'expires_at' => now()->subMinute(),
        ]);

        $this->artisan('reservations:release-expired')->assertSuccessful();

        $product->refresh();
        $this->assertEquals(5, $product->stock);

        // Now buyer 2 can checkout
        $response = $this->actingAs($buyer2)->get('/orders/create');
        $response->assertOk();

        $product->refresh();
        $this->assertEquals(1, $product->stock);
    }

    public function test_checkout_page_shows_reservation_countdown(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($buyer)->get('/orders/create');

        $response->assertOk();
        $response->assertViewHas('reservationExpiresAt');
        $response->assertSee('Stok Direservasi');
    }

    public function test_order_without_visiting_checkout_still_works(): void
    {
        [$buyer, , , $product] = $this->setupData();

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Post directly without visiting checkout (backward compatibility)
        $response = $this->actingAs($buyer)->post('/orders', [
            'address_id' => $buyer->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('orders.show', 1));

        $product->refresh();
        $this->assertEquals(3, $product->stock);
        $this->assertDatabaseEmpty('stock_reservations');
    }
}
