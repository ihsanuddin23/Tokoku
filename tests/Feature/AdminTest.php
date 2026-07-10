<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\SellerProfile;
use App\Models\SellerVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    // --- Admin Access ---

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_cannot_access_admin_dashboard(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_seller_cannot_access_admin_dashboard(): void
    {
        $seller = User::factory()->seller()->create();
        $this->actingAs($seller)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    // --- User Management ---

    public function test_admin_can_view_users_list(): void
    {
        User::factory()->buyer()->create();
        $this->actingAs($this->admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertViewIs('admin.users.index');
    }

    public function test_admin_can_toggle_user_active_status(): void
    {
        $buyer = User::factory()->buyer()->create(['is_active' => 1]);

        $this->actingAs($this->admin)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->patch(route('admin.users.toggle-active', $buyer))
            ->assertRedirect();

        $this->assertFalse($buyer->fresh()->is_active);
    }

    public function test_admin_cannot_toggle_own_account(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->patch(route('admin.users.toggle-active', $this->admin))
            ->assertSessionHas('info');
    }

    public function test_admin_cannot_toggle_other_admin(): void
    {
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($this->admin)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->patch(route('admin.users.toggle-active', $otherAdmin))
            ->assertSessionHas('info');
    }

    // --- Seller Verification ---

    public function test_admin_can_view_verifications_list(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Test Store',
            'city' => 'Jakarta',
            'status' => 'pending',
        ])->save();

        $this->actingAs($this->admin)
            ->get(route('admin.verifications.index'))
            ->assertOk()
            ->assertViewIs('admin.verifications.index');
    }

    public function test_admin_can_approve_seller_verification(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Sukses',
            'city' => 'Jakarta',
            'description' => 'Toko terpercaya',
            'status' => 'pending',
        ])->save();

        $this->actingAs($this->admin)
            ->patch(route('admin.verifications.approve', $verification))
            ->assertRedirect();

        $this->assertEquals('approved', $verification->fresh()->status);
        $this->assertEquals('seller', $buyer->fresh()->role);
        $this->assertNotNull($buyer->fresh()->sellerProfile);
        $this->assertTrue($buyer->fresh()->sellerProfile->is_verified);
    }

    public function test_admin_can_reject_seller_verification(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Gagal',
            'city' => 'Bandung',
            'status' => 'pending',
        ])->save();

        $this->actingAs($this->admin)
            ->patch(route('admin.verifications.reject', $verification), [
                'admin_note' => 'Data tidak lengkap',
            ])
            ->assertRedirect();

        $this->assertEquals('rejected', $verification->fresh()->status);
        $this->assertEquals('Data tidak lengkap', $verification->fresh()->admin_note);
    }

    public function test_reject_validates_admin_note_required(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Test',
            'city' => 'Jakarta',
            'status' => 'pending',
        ])->save();

        $this->actingAs($this->admin)
            ->patch(route('admin.verifications.reject', $verification), [])
            ->assertSessionHasErrors(['admin_note']);
    }

    public function test_cannot_approve_already_processed_verification(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Test',
            'city' => 'Jakarta',
            'status' => 'approved',
        ])->save();

        $this->actingAs($this->admin)
            ->patch(route('admin.verifications.approve', $verification))
            ->assertSessionHas('info');
    }

    // --- Category Management ---

    public function test_admin_can_view_categories_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertViewIs('admin.categories.index');
    }

    public function test_admin_can_create_category(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Elektronik',
                'icon' => '📱',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Elektronik']);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->admin)
            ->patch(route('admin.categories.update', $category), [
                'name' => 'New Name',
                'icon' => '📦',
            ])
            ->assertRedirect();

        $this->assertEquals('New Name', $category->fresh()->name);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $this->actingAs($this->admin)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect();

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    // --- Order Management ---

    public function test_admin_can_view_orders_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertViewIs('admin.orders.index');
    }

    public function test_admin_can_view_order_detail(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-ADMIN001',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $this->actingAs($this->admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertViewIs('admin.orders.show');
    }

    public function test_admin_can_update_order_status(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-ADMIN002',
            'status' => 'paid',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $this->actingAs($this->admin)
            ->patch(route('admin.orders.update-status', $order), [
                'status' => 'shipped',
            ])
            ->assertRedirect();

        $this->assertEquals('shipped', $order->fresh()->status);
    }

    // --- Return Management ---

    public function test_admin_can_view_returns_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.returns.index'))
            ->assertOk()
            ->assertViewIs('admin.returns.index');
    }

    public function test_admin_can_approve_return(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-RET-ADMIN',
            'status' => 'completed',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $return = ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => $buyer->id,
            'reason' => 'Barang rusak',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.returns.approve', $return))
            ->assertRedirect();

        $this->assertEquals('approved', $return->fresh()->status);
    }

    public function test_admin_can_reject_return(): void
    {
        $buyer = User::factory()->buyer()->create();
        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-RET-REJ',
            'status' => 'completed',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $return = ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => $buyer->id,
            'reason' => 'Tidak sesuai',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.returns.reject', $return), [
                'admin_note' => 'Tidak memenuhi syarat retur',
            ])
            ->assertRedirect();

        $this->assertEquals('rejected', $return->fresh()->status);
    }

    // --- Product Management ---

    public function test_admin_can_view_products_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertViewIs('admin.products.index');
    }

    public function test_admin_can_toggle_product_status(): void
    {
        Category::factory()->create(['is_active' => true]);
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $product = Product::factory()->active()->create([
            'seller_profile_id' => $sellerProfile->id,
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.products.toggle-status', $product))
            ->assertRedirect();

        $this->assertEquals('inactive', $product->fresh()->status);
    }
}
