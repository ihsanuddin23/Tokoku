<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReturnRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private SellerProfile $sellerProfile;
    private Product $product;
    private Order $completedOrder;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Models\Category::factory()->create(['is_active' => true]);
        $this->buyer = User::factory()->buyer()->create();
        $this->seller = User::factory()->seller()->create();
        $this->sellerProfile = SellerProfile::factory()->create(['user_id' => $this->seller->id]);
        $this->product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
        ]);

        $address = Address::create([
            'user_id' => $this->buyer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
        ]);

        $this->completedOrder = new Order;
        $this->completedOrder->user_id = $this->buyer->id;
        $this->completedOrder->forceFill([
            'order_number' => 'ORD-RET001',
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'midtrans',
            'subtotal' => 50000,
            'shipping_cost' => 15000,
            'grand_total' => 65000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
            'paid_at' => now()->subDays(5),
            'completed_at' => now()->subDay(),
        ])->save();

        OrderItem::create([
            'order_id' => $this->completedOrder->id,
            'product_id' => $this->product->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_name' => $this->product->name,
            'product_price' => 50000,
            'quantity' => 1,
            'subtotal' => 50000,
            'status' => 'completed',
        ]);
    }

    public function test_guest_cannot_access_returns_index(): void
    {
        $this->get(route('returns.index'))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_can_view_returns_index(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('returns.index'))
            ->assertOk()
            ->assertViewIs('returns.index');
    }

    public function test_buyer_can_view_create_return_for_completed_order(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('returns.create', $this->completedOrder))
            ->assertOk()
            ->assertViewIs('returns.create');
    }

    public function test_buyer_cannot_create_return_for_pending_order(): void
    {
        $pendingOrder = new Order;
        $pendingOrder->user_id = $this->buyer->id;
        $pendingOrder->forceFill([
            'order_number' => 'ORD-RET002',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => 30000,
            'shipping_cost' => 15000,
            'grand_total' => 45000,
            'shipping_address' => 'Test',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        $this->actingAs($this->buyer)
            ->get(route('returns.create', $pendingOrder))
            ->assertRedirect(route('orders.show', $pendingOrder));
    }

    public function test_buyer_can_submit_return_request(): void
    {
        $this->actingAs($this->buyer)
            ->post(route('returns.store', $this->completedOrder), [
                'reason' => 'Barang rusak',
                'description' => 'Produk datang dalam kondisi rusak',
            ])
            ->assertRedirect(route('returns.index'));

        $this->assertDatabaseHas('return_requests', [
            'order_id' => $this->completedOrder->id,
            'user_id' => $this->buyer->id,
            'reason' => 'Barang rusak',
            'status' => 'pending',
        ]);
    }

    public function test_return_validates_reason_required(): void
    {
        $this->actingAs($this->buyer)
            ->post(route('returns.store', $this->completedOrder), [])
            ->assertSessionHasErrors(['reason']);
    }

    public function test_buyer_cannot_create_duplicate_return(): void
    {
        ReturnRequest::create([
            'order_id' => $this->completedOrder->id,
            'user_id' => $this->buyer->id,
            'reason' => 'Barang rusak',
            'status' => 'pending',
        ]);

        $this->actingAs($this->buyer)
            ->get(route('returns.create', $this->completedOrder))
            ->assertRedirect(route('orders.show', $this->completedOrder));
    }

    public function test_other_user_cannot_create_return(): void
    {
        $otherUser = User::factory()->buyer()->create();

        $this->actingAs($otherUser)
            ->get(route('returns.create', $this->completedOrder))
            ->assertForbidden();
    }

    public function test_return_with_specific_order_item(): void
    {
        $orderItem = $this->completedOrder->items->first();

        $this->actingAs($this->buyer)
            ->post(route('returns.store', $this->completedOrder), [
                'reason' => 'Tidak sesuai deskripsi',
                'description' => 'Warna berbeda',
                'order_item_id' => $orderItem->id,
            ])
            ->assertRedirect(route('returns.index'));

        $this->assertDatabaseHas('return_requests', [
            'order_id' => $this->completedOrder->id,
            'order_item_id' => $orderItem->id,
        ]);
    }

    public function test_return_with_invalid_order_item_id(): void
    {
        $this->actingAs($this->buyer)
            ->post(route('returns.store', $this->completedOrder), [
                'reason' => 'Tidak sesuai',
                'order_item_id' => 99999,
            ])
            ->assertSessionHasErrors(['order_item_id']);

        $this->assertDatabaseMissing('return_requests', [
            'order_id' => $this->completedOrder->id,
            'order_item_id' => 99999,
        ]);
    }

    public function test_returns_index_shows_user_returns(): void
    {
        ReturnRequest::create([
            'order_id' => $this->completedOrder->id,
            'user_id' => $this->buyer->id,
            'reason' => 'Barang rusak',
            'status' => 'pending',
        ]);

        $this->actingAs($this->buyer)
            ->get(route('returns.index'))
            ->assertOk()
            ->assertViewHas('returns');
    }
}
