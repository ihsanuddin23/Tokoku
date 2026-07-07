<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function setupBuyerWithCartAndAddress(): array
    {
        $buyer = User::factory()->buyer()->create();
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 20,
            'total_sold' => 0,
            'status' => 'active',
        ]);

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

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        return [$buyer, $product, $address];
    }

    public function test_buyer_can_view_orders_list(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get('/orders');

        $response->assertStatus(200);
    }

    public function test_buyer_can_view_checkout_page(): void
    {
        [$buyer] = $this->setupBuyerWithCartAndAddress();

        $response = $this->actingAs($buyer)->get('/orders/create');

        $response->assertStatus(200);
    }

    public function test_checkout_redirects_when_cart_empty(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get('/orders/create');

        $response->assertStatus(200);
        $response->assertViewIs('orders.empty');
    }

    public function test_buyer_can_create_order(): void
    {
        [$buyer, $product, $address] = $this->setupBuyerWithCartAndAddress();

        $response = $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'notes' => 'Test order notes',
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = \App\Models\Order::where('user_id', $buyer->id)->latest()->first();
        $response->assertRedirect(route('payment.show', $order));
        $this->assertDatabaseHas('orders', [
            'user_id' => $buyer->id,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
        ]);
    }

    public function test_order_creation_decrements_stock(): void
    {
        [$buyer, $product, $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $this->assertEquals(18, $product->fresh()->stock);
        $this->assertEquals(2, $product->fresh()->total_sold);
    }

    public function test_buyer_can_view_own_order(): void
    {
        [$buyer, , $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();

        $response = $this->actingAs($buyer)->get("/orders/{$order->id}");

        $response->assertStatus(200);
    }

    public function test_buyer_cannot_view_other_user_order(): void
    {
        [$buyer, , $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $otherBuyer = User::factory()->buyer()->create();

        $response = $this->actingAs($otherBuyer)->get("/orders/{$order->id}");

        $response->assertStatus(403);
    }

    public function test_buyer_can_cancel_pending_order(): void
    {
        [$buyer, , $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();

        $response = $this->actingAs($buyer)->patch("/orders/{$order->id}/cancel");

        $response->assertRedirect();
        $this->assertEquals('cancelled', $order->fresh()->status);
        $this->assertEquals('unpaid', $order->fresh()->payment_status);
    }

    public function test_cancel_order_restores_stock(): void
    {
        [$buyer, $product, $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $this->actingAs($buyer)->patch("/orders/{$order->id}/cancel");

        $this->assertEquals(20, $product->fresh()->stock);
    }

    public function test_buyer_cannot_cancel_completed_order(): void
    {
        [$buyer, , $address] = $this->setupBuyerWithCartAndAddress();

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => $address->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $order->forceFill(['status' => 'completed'])->save();

        $response = $this->actingAs($buyer)->patch("/orders/{$order->id}/cancel");

        $response->assertSessionHas('info');
        $this->assertEquals('completed', $order->fresh()->status);
    }

    public function test_guest_cannot_access_orders(): void
    {
        $response = $this->get('/orders');

        $response->assertRedirect(route('login'));
    }
}
