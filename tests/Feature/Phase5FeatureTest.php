<?php

namespace Tests\Feature;

use App\Mail\LowStockAlert;
use App\Mail\NewOrderSeller;
use App\Mail\OrderPlacedBuyer;
use App\Mail\OrderStatusUpdated;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class Phase5FeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createBuyerWithProductAndCart(): array
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'active',
        ]);

        $buyer = User::factory()->buyer()->create();
        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        Address::create([
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

        return [$buyer, $seller, $sellerProfile, $product];
    }

    public function test_buyer_receives_email_when_order_placed(): void
    {
        Mail::fake();

        [$buyer, $seller, $sellerProfile, $product] = $this->createBuyerWithProductAndCart();

        $response = $this->actingAs($buyer)->post(route('orders.store'), [
            'address_id' => $buyer->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
            'notes' => 'Test order',
        ]);

        Mail::assertQueued(OrderPlacedBuyer::class, fn ($mail) => $mail->order->user_id === $buyer->id);
    }

    public function test_seller_receives_email_when_order_placed(): void
    {
        Mail::fake();

        [$buyer, $seller, $sellerProfile, $product] = $this->createBuyerWithProductAndCart();

        $response = $this->actingAs($buyer)->post(route('orders.store'), [
            'address_id' => $buyer->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
            'notes' => 'Test order',
        ]);

        Mail::assertNotSent(NewOrderSeller::class);
    }

    public function test_buyer_receives_email_when_seller_updates_status(): void
    {
        Mail::fake();

        [$buyer, $seller, $sellerProfile, $product] = $this->createBuyerWithProductAndCart();

        $order = Order::forceCreate([
            'order_number' => 'ORD-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'user_id' => $buyer->id,
            'address_id' => $buyer->addresses()->first()->id,
            'status' => 'pending',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test Address',
        ]);

        $orderItem = OrderItem::forceCreate([
            'order_id' => $order->id,
            'seller_profile_id' => $sellerProfile->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($seller)
            ->patch(route('seller.orders.update-status', $orderItem), [
                'status' => 'paid',
            ]);

        $response->assertRedirect(route('seller.orders.index'));

        Mail::assertQueued(OrderStatusUpdated::class, fn ($mail) => $mail->order->id === $order->id && $mail->newStatus === 'paid');
    }

    public function test_low_stock_email_sent_when_stock_drops_after_order(): void
    {
        Mail::fake();

        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 6,
            'status' => 'active',
        ]);

        $buyer = User::factory()->buyer()->create();
        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        Address::create([
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

        $response = $this->actingAs($buyer)->post(route('orders.store'), [
            'address_id' => $buyer->addresses()->first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'midtrans',
            'notes' => 'Test order',
        ]);

        Mail::assertQueued(LowStockAlert::class, fn ($mail) => $mail->product->id === $product->id);
    }

    public function test_buyer_can_download_invoice_pdf(): void
    {
        [$buyer, $seller, $sellerProfile, $product] = $this->createBuyerWithProductAndCart();

        $order = Order::forceCreate([
            'order_number' => 'ORD-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'user_id' => $buyer->id,
            'address_id' => $buyer->addresses()->first()->id,
            'status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test Address',
        ]);

        OrderItem::forceCreate([
            'order_id' => $order->id,
            'seller_profile_id' => $sellerProfile->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'paid',
        ]);

        $response = $this->actingAs($buyer)->get(route('orders.invoice', $order));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_other_user_cannot_download_invoice(): void
    {
        [$buyer, $seller, $sellerProfile, $product] = $this->createBuyerWithProductAndCart();

        $order = Order::forceCreate([
            'order_number' => 'ORD-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'user_id' => $buyer->id,
            'address_id' => $buyer->addresses()->first()->id,
            'status' => 'paid',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test Address',
        ]);

        $otherUser = User::factory()->buyer()->create();

        $response = $this->actingAs($otherUser)->get(route('orders.invoice', $order));

        $response->assertStatus(403);
    }

    public function test_seller_can_access_reports_page(): void
    {
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);

        $response = $this->actingAs($seller)->get(route('seller.reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan');
    }

    public function test_seller_can_export_report_pdf(): void
    {
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);

        $response = $this->actingAs($seller)->get(route('seller.reports.export-pdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_access_reports_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Platform');
    }

    public function test_admin_can_export_report_pdf(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.reports.export-pdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_seller_dashboard_shows_real_sales_chart_data(): void
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'status' => 'active',
       ]);

        $response = $this->actingAs($seller)->get(route('seller.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('salesData');
        $response->assertViewHas('maxRevenue');
        $response->assertViewHas('lowStockProducts');
    }

    public function test_admin_dashboard_shows_real_sales_chart_data(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('salesData');
        $response->assertViewHas('maxRevenue');
        $response->assertViewHas('recentOrders');
    }

    public function test_seller_dashboard_shows_low_stock_products(): void
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id, 'is_verified' => true, 'is_active' => true]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 3,
            'status' => 'active',
        ]);

        $response = $this->actingAs($seller)->get(route('seller.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Stok Menipis');
    }
}
