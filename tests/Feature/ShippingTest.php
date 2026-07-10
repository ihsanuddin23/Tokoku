<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingTest extends TestCase
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

    public function test_shipping_service_returns_couriers(): void
    {
        $service = app(\App\Services\ShippingService::class);
        $couriers = $service->getCouriers();

        $this->assertNotEmpty($couriers);
        $this->assertGreaterThanOrEqual(6, count($couriers));
    }

    public function test_shipping_service_returns_costs(): void
    {
        $service = app(\App\Services\ShippingService::class);
        $costs = $service->getCosts();

        $this->assertArrayHasKey('jne', $costs);
        $this->assertArrayHasKey('jnt', $costs);
        $this->assertGreaterThan(0, $costs['jne']);
    }

    public function test_shipping_service_returns_services(): void
    {
        $service = app(\App\Services\ShippingService::class);
        $services = $service->getServices();

        $this->assertArrayHasKey('jne', $services);
        $this->assertEquals('REG', $services['jne']);
    }

    public function test_shipping_cost_fallback_without_api_key(): void
    {
        $service = app(\App\Services\ShippingService::class);
        $result = $service->getShippingCost('jne');

        $this->assertArrayHasKey('cost', $result);
        $this->assertArrayHasKey('service', $result);
        $this->assertArrayHasKey('eta', $result);
        $this->assertEquals(15000, $result['cost']);
    }

    public function test_shipping_cost_fallback_for_unknown_courier(): void
    {
        $service = app(\App\Services\ShippingService::class);
        $result = $service->getShippingCost('unknown');

        $this->assertEquals(15000, $result['cost']);
        $this->assertEquals('REG', $result['service']);
    }

    private function createAddress(): \App\Models\Address
    {
        return \App\Models\Address::create([
            'user_id' => $this->buyer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test User',
            'phone' => '081234567890',
            'full_address' => 'Jl. Test No. 123',
            'district' => 'Test District',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
        ]);
    }

    public function test_checkout_page_shows_shipping_options(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($this->buyer)
            ->get(route('orders.create'))
            ->assertOk()
            ->assertViewIs('orders.create');
    }

    public function test_order_create_validates_shipping_courier(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $address = $this->createAddress();

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => $address->id,
                'shipping_courier' => 'invalid_courier',
                'payment_method' => 'cod',
            ])
            ->assertSessionHasErrors(['shipping_courier']);
    }

    public function test_order_create_validates_payment_method(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $address = $this->createAddress();

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => $address->id,
                'shipping_courier' => 'jne',
                'payment_method' => 'invalid_method',
            ])
            ->assertSessionHasErrors(['payment_method']);
    }

    public function test_order_create_validates_address_id(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => 99999,
                'shipping_courier' => 'jne',
                'payment_method' => 'cod',
            ])
            ->assertSessionHasErrors(['address_id']);
    }

    public function test_checkout_with_empty_cart_shows_empty_view(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('orders.create'))
            ->assertOk()
            ->assertViewIs('orders.empty');
    }

    public function test_order_with_cod_creates_successfully(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
            'weight' => 500,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $address = $this->createAddress();

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => $address->id,
                'shipping_courier' => 'jne',
                'payment_method' => 'cod',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->buyer->id,
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $this->buyer->id,
        ]);
    }

    public function test_order_decrements_product_stock(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
            'weight' => 500,
            'total_sold' => 0,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $address = $this->createAddress();

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => $address->id,
                'shipping_courier' => 'jne',
                'payment_method' => 'cod',
            ]);

        $this->assertEquals(7, $product->fresh()->stock);
        $this->assertEquals(3, $product->fresh()->total_sold);
    }

    public function test_order_with_insufficient_stock_fails(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 2,
            'weight' => 500,
        ]);

        $this->buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $address = $this->createAddress();

        $this->actingAs($this->buyer)
            ->post(route('orders.store'), [
                'address_id' => $address->id,
                'shipping_courier' => 'jne',
                'payment_method' => 'cod',
            ])
            ->assertSessionHasErrors(['stock']);
    }
}
