<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_dashboard_loads(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewIs('dashboard');
    }

    public function test_buyer_dashboard_shows_recent_orders(): void
    {
        Category::factory()->create(['is_active' => true]);
        $buyer = User::factory()->buyer()->create();
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $product = Product::factory()->active()->create(['seller_profile_id' => $sellerProfile->id]);

        $order = new Order;
        $order->user_id = $buyer->id;
        $order->forceFill([
            'order_number' => 'ORD-DASH001',
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'midtrans',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
            'paid_at' => now()->subDay(),
            'completed_at' => now(),
        ])->save();

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_profile_id' => $sellerProfile->id,
            'product_name' => $product->name,
            'product_price' => 50000,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'completed',
        ]);

        $this->actingAs($buyer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('recentOrders')
            ->assertViewHas('totalOrders')
            ->assertViewHas('totalSpent')
            ->assertViewHas('completedOrders');
    }

    public function test_buyer_dashboard_total_spent_excludes_non_completed(): void
    {
        $buyer = User::factory()->buyer()->create();

        $order1 = new Order;
        $order1->user_id = $buyer->id;
        $order1->forceFill([
            'order_number' => 'ORD-001',
            'status' => 'completed',
            'payment_status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
            'paid_at' => now(),
            'completed_at' => now(),
        ])->save();

        $order2 = new Order;
        $order2->user_id = $buyer->id;
        $order2->forceFill([
            'order_number' => 'ORD-002',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => 30000,
            'shipping_cost' => 15000,
            'grand_total' => 45000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $response = $this->actingAs($buyer)->get(route('dashboard'));
        $response->assertOk();
        $this->assertEquals(65000, (float) $response->viewData('totalSpent'));
        $this->assertEquals(1, $response->viewData('completedOrders'));
    }

    public function test_admin_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_dashboard_loads(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('admin.dashboard');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_seller_redirected_to_seller_dashboard(): void
    {
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);

        $this->actingAs($seller)
            ->get(route('dashboard'))
            ->assertRedirect(route('seller.dashboard'));
    }

    public function test_seller_dashboard_loads(): void
    {
        Category::factory()->create(['is_active' => true]);
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);
        Product::factory()->active()->create([
            'seller_profile_id' => $seller->sellerProfile->id,
        ]);

        $this->actingAs($seller)
            ->get(route('seller.dashboard'))
            ->assertOk()
            ->assertViewIs('seller.dashboard');
    }

    public function test_seller_dashboard_shows_low_stock_products(): void
    {
        Category::factory()->create(['is_active' => true]);
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'seller_profile_id' => $seller->sellerProfile->id,
            'stock' => 3,
            'status' => 'active',
        ]);

        $response = $this->actingAs($seller)->get(route('seller.dashboard'));
        $response->assertOk();
        $response->assertViewHas('lowStockProducts');
        $this->assertCount(1, $response->viewData('lowStockProducts'));
    }

    public function test_seller_dashboard_shows_top_products(): void
    {
        Category::factory()->create(['is_active' => true]);
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'seller_profile_id' => $seller->sellerProfile->id,
            'total_sold' => 100,
            'status' => 'active',
        ]);

        $response = $this->actingAs($seller)->get(route('seller.dashboard'));
        $response->assertOk();
        $response->assertViewHas('topProducts');
    }

    public function test_admin_dashboard_shows_pending_verifications(): void
    {
        $admin = User::factory()->admin()->create();
        $buyer = User::factory()->buyer()->create();
        $buyer->sellerVerification()->create([
            'store_name' => 'Test Store',
            'city' => 'Jakarta',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $this->assertEquals(1, $response->viewData('pendingVerifications'));
    }

    public function test_admin_dashboard_shows_totals(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertOk()
            ->assertViewHas('totalUsers')
            ->assertViewHas('totalSellers')
            ->assertViewHas('totalProducts')
            ->assertViewHas('totalOrders')
            ->assertViewHas('totalRevenue');
    }
}
