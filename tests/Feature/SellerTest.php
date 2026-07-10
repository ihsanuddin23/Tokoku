<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use RefreshDatabase;

    private User $seller;
    private SellerProfile $sellerProfile;

    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->create(['is_active' => true]);
        $this->seller = User::factory()->seller()->create();
        $this->sellerProfile = SellerProfile::factory()->create([
            'user_id' => $this->seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);
    }

    // --- Access Control ---

    public function test_guest_cannot_access_seller_dashboard(): void
    {
        $this->get(route('seller.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_cannot_access_seller_dashboard(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->get(route('seller.dashboard'))
            ->assertForbidden();
    }

    public function test_unverified_seller_cannot_access_dashboard(): void
    {
        $unverified = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $unverified->id,
            'is_verified' => false,
            'is_active' => true,
        ]);

        $this->actingAs($unverified)
            ->get(route('seller.dashboard'))
            ->assertRedirect('/');
    }

    public function test_inactive_seller_cannot_access_dashboard(): void
    {
        $inactive = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $inactive->id,
            'is_verified' => true,
            'is_active' => false,
        ]);

        $this->actingAs($inactive)
            ->get(route('seller.dashboard'))
            ->assertRedirect('/');
    }

    // --- Products ---

    public function test_seller_can_view_products_list(): void
    {
        Product::factory()->active()->create(['seller_profile_id' => $this->sellerProfile->id]);

        $this->actingAs($this->seller)
            ->get(route('seller.products.index'))
            ->assertOk()
            ->assertViewIs('seller.products.index');
    }

    public function test_seller_can_view_create_product_form(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.products.create'))
            ->assertOk()
            ->assertViewIs('seller.products.create');
    }

    public function test_seller_can_create_product(): void
    {
        $this->actingAs($this->seller)
            ->post(route('seller.products.store'), [
                'category_id' => Category::first()->id,
                'name' => 'Produk Test',
                'description' => 'Deskripsi produk test',
                'price' => 50000,
                'stock' => 10,
                'weight' => 500,
                'condition' => 'new',
                'status' => 'active',
                'images' => [],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'seller_profile_id' => $this->sellerProfile->id,
            'name' => 'Produk Test',
            'price' => 50000,
        ]);
    }

    public function test_seller_can_edit_product(): void
    {
        $product = Product::factory()->active()->create(['seller_profile_id' => $this->sellerProfile->id]);

        $this->actingAs($this->seller)
            ->get(route('seller.products.edit', $product))
            ->assertOk()
            ->assertViewIs('seller.products.edit');
    }

    public function test_seller_can_update_product(): void
    {
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'name' => 'Old Name',
        ]);

        $this->actingAs($this->seller)
            ->patch(route('seller.products.update', $product), [
                'category_id' => $product->category_id,
                'name' => 'Updated Name',
                'description' => $product->description,
                'price' => 75000,
                'stock' => 20,
                'weight' => 500,
                'condition' => 'new',
                'status' => 'active',
                'images' => [],
            ])
            ->assertRedirect();

        $this->assertEquals('Updated Name', $product->fresh()->name);
    }

    public function test_seller_can_delete_product(): void
    {
        $product = Product::factory()->active()->create(['seller_profile_id' => $this->sellerProfile->id]);

        $this->actingAs($this->seller)
            ->delete(route('seller.products.destroy', $product))
            ->assertRedirect();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_seller_cannot_edit_other_seller_product(): void
    {
        $otherSeller = User::factory()->seller()->create();
        $otherProfile = SellerProfile::factory()->create(['user_id' => $otherSeller->id]);
        $product = Product::factory()->active()->create(['seller_profile_id' => $otherProfile->id]);

        $this->actingAs($this->seller)
            ->get(route('seller.products.edit', $product))
            ->assertForbidden();
    }

    // --- Vouchers ---

    public function test_seller_can_view_vouchers_list(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.vouchers.index'))
            ->assertOk()
            ->assertViewIs('seller.vouchers.index');
    }

    public function test_seller_can_view_create_voucher_form(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.vouchers.create'))
            ->assertOk()
            ->assertViewIs('seller.vouchers.create');
    }

    public function test_seller_can_create_voucher(): void
    {
        $this->actingAs($this->seller)
            ->post(route('seller.vouchers.store'), [
                'code' => 'HEMAT50',
                'name' => 'Diskon Hemat',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 50000,
                'max_discount' => 25000,
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'starts_at' => now()->format('Y-m-d'),
                'expires_at' => now()->addDays(7)->format('Y-m-d'),
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('vouchers', [
            'seller_profile_id' => $this->sellerProfile->id,
            'code' => 'HEMAT50',
        ]);
    }

    public function test_seller_can_edit_voucher(): void
    {
        $voucher = new Voucher;
        $voucher->seller_profile_id = $this->sellerProfile->id;
        $voucher->forceFill([
            'code' => 'OLD123',
            'name' => 'Voucher Lama',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(7),
            'usage_limit_per_user' => 1,
        ])->save();

        $this->actingAs($this->seller)
            ->get(route('seller.vouchers.edit', $voucher))
            ->assertOk()
            ->assertViewIs('seller.vouchers.edit');
    }

    public function test_seller_can_delete_voucher(): void
    {
        $voucher = new Voucher;
        $voucher->seller_profile_id = $this->sellerProfile->id;
        $voucher->forceFill([
            'code' => 'DEL123',
            'name' => 'Voucher Delete',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(7),
            'usage_limit_per_user' => 1,
        ])->save();

        $this->actingAs($this->seller)
            ->delete(route('seller.vouchers.destroy', $voucher))
            ->assertRedirect();

        $this->assertDatabaseMissing('vouchers', ['id' => $voucher->id]);
    }

    public function test_seller_cannot_edit_other_seller_voucher(): void
    {
        $otherSeller = User::factory()->seller()->create();
        $otherProfile = SellerProfile::factory()->create(['user_id' => $otherSeller->id]);

        $voucher = new Voucher;
        $voucher->seller_profile_id = $otherProfile->id;
        $voucher->forceFill([
            'code' => 'OTHER123',
            'name' => 'Other Voucher',
            'type' => 'fixed',
            'value' => 5000,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(7),
            'usage_limit_per_user' => 1,
        ])->save();

        $this->actingAs($this->seller)
            ->get(route('seller.vouchers.edit', $voucher))
            ->assertForbidden();
    }

    // --- Orders ---

    public function test_seller_can_view_orders_list(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.orders.index'))
            ->assertOk()
            ->assertViewIs('seller.orders.index');
    }

    public function test_seller_can_view_order_detail(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-SELLER01',
            'status' => 'paid',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => Product::factory()->active()->create(['seller_profile_id' => $this->sellerProfile->id])->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_name' => 'Test Product',
            'product_price' => 50000,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'paid',
        ]);

        $this->actingAs($this->seller)
            ->get(route('seller.orders.show', $order))
            ->assertOk()
            ->assertViewIs('seller.orders.show');
    }

    public function test_seller_can_update_order_item_status(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-SELLER02',
            'status' => 'paid',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => Product::factory()->active()->create(['seller_profile_id' => $this->sellerProfile->id])->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_name' => 'Test Product',
            'product_price' => 50000,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'paid',
        ]);

        $this->actingAs($this->seller)
            ->patch(route('seller.orders.update-status', $item), [
                'status' => 'shipped',
                'tracking_number' => 'JNE123',
            ])
            ->assertRedirect();

        $this->assertEquals('shipped', $item->fresh()->status);
    }

    // --- Store Settings ---

    public function test_seller_can_view_store_settings(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.store.edit'))
            ->assertOk()
            ->assertViewIs('seller.store.edit');
    }

    public function test_seller_can_update_store_settings(): void
    {
        $this->actingAs($this->seller)
            ->patch(route('seller.store.update'), [
                'store_name' => 'Toko Updated',
                'description' => 'Deskripsi toko baru',
                'city' => 'Bandung',
                'banner' => null,
                'logo' => null,
            ])
            ->assertRedirect();

        $this->assertEquals('Toko Updated', $this->sellerProfile->fresh()->store_name);
    }

    // --- Reviews ---

    public function test_seller_can_view_reviews(): void
    {
        $this->actingAs($this->seller)
            ->get(route('seller.reviews.index'))
            ->assertOk()
            ->assertViewIs('seller.reviews.index');
    }
}
