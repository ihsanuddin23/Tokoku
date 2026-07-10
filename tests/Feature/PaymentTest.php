<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private SellerProfile $sellerProfile;
    private Product $product;
    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Models\Category::factory()->create(['is_active' => true]);
        $this->buyer = User::factory()->buyer()->create();
        $this->seller = User::factory()->seller()->create();
        $this->sellerProfile = SellerProfile::factory()->create([
            'user_id' => $this->seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);
        $this->product = Product::factory()->active()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'stock' => 10,
            'weight' => 500,
            'total_sold' => 0,
        ]);

        $address = Address::create([
            'user_id' => $this->buyer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test User',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test No. 123',
            'is_default' => true,
        ]);

        $this->order = new Order;
        $this->order->user_id = $this->buyer->id;
        $this->order->forceFill([
            'order_number' => 'ORD-TEST001',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'midtrans',
            'subtotal' => 100000,
            'shipping_cost' => 15000,
            'grand_total' => 115000,
            'shipping_address' => 'Jl. Test No. 123',
            'shipping_courier' => 'jne',
            'shipping_service' => 'REG',
        ])->save();

        OrderItem::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_name' => $this->product->name,
            'product_price' => 100000,
            'quantity' => 1,
            'subtotal' => 100000,
            'status' => 'pending',
        ]);
    }

    public function test_guest_cannot_access_payment(): void
    {
        $this->get(route('payment.show', $this->order))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_can_view_payment_page(): void
    {
        Payment::create([
            'order_id' => $this->order->id,
            'midtrans_order_id' => 'TOKOKU-TEST-001',
            'snap_token' => 'test-snap-token',
            'gross_amount' => 115000,
            'transaction_status' => 'pending',
        ]);

        $this->actingAs($this->buyer)
            ->get(route('payment.show', $this->order))
            ->assertOk()
            ->assertViewIs('payment.show');
    }

    public function test_other_user_cannot_view_payment(): void
    {
        $otherUser = User::factory()->buyer()->create();

        $this->actingAs($otherUser)
            ->get(route('payment.show', $this->order))
            ->assertForbidden();
    }

    public function test_payment_redirects_if_order_cannot_be_paid(): void
    {
        $this->order->forceFill(['status' => 'completed', 'payment_status' => 'paid'])->save();

        $this->actingAs($this->buyer)
            ->get(route('payment.show', $this->order))
            ->assertRedirect(route('orders.show', $this->order));
    }

    public function test_payment_finish_with_pending_status(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('payment.finish', $this->order) . '?transaction_status=pending')
            ->assertRedirect(route('orders.show', $this->order));
    }

    public function test_payment_finish_with_failure_status(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('payment.finish', $this->order) . '?transaction_status=deny')
            ->assertRedirect(route('orders.show', $this->order));
    }

    public function test_payment_success_page_loads(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('payment.success', $this->order))
            ->assertOk()
            ->assertViewIs('payment.success');
    }

    public function test_webhook_with_invalid_payload_returns_400(): void
    {
        $this->postJson(route('payment.webhook'), [])
            ->assertStatus(400);
    }

    public function test_webhook_with_invalid_signature_returns_403(): void
    {
        $this->postJson(route('payment.webhook'), [
            'order_id' => 'TOKOKU-TEST-001',
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'signature_key' => 'invalid-signature',
        ])->assertStatus(403);
    }

    public function test_webhook_with_valid_signature_processes_payment(): void
    {
        $payment = Payment::create([
            'order_id' => $this->order->id,
            'midtrans_order_id' => 'TOKOKU-TEST-001',
            'snap_token' => 'test-token',
            'gross_amount' => 115000,
            'transaction_status' => 'pending',
        ]);

        $signatureKey = hash('sha512',
            'TOKOKU-TEST-001' .
            '200' .
            'settlement' .
            'accept' .
            config('midtrans.server_key')
        );

        $this->postJson(route('payment.webhook'), [
            'order_id' => 'TOKOKU-TEST-001',
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'transaction_id' => 'TX-123',
            'payment_type' => 'bank_transfer',
            'signature_key' => $signatureKey,
        ])->assertOk();

        $this->assertEquals('paid', $this->order->fresh()->status);
        $this->assertEquals('paid', $this->order->fresh()->payment_status);
        $this->assertEquals('settlement', $payment->fresh()->transaction_status);
    }

    public function test_webhook_already_processed_returns_ok(): void
    {
        Payment::create([
            'order_id' => $this->order->id,
            'midtrans_order_id' => 'TOKOKU-TEST-002',
            'snap_token' => 'test-token',
            'gross_amount' => 115000,
            'transaction_status' => 'settlement',
        ]);

        $signatureKey = hash('sha512',
            'TOKOKU-TEST-002' .
            '200' .
            'settlement' .
            'accept' .
            config('midtrans.server_key')
        );

        $this->postJson(route('payment.webhook'), [
            'order_id' => 'TOKOKU-TEST-002',
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'signature_key' => $signatureKey,
        ])->assertOk();
    }

    public function test_webhook_cancel_status_marks_payment_failed(): void
    {
        Payment::create([
            'order_id' => $this->order->id,
            'midtrans_order_id' => 'TOKOKU-TEST-003',
            'snap_token' => 'test-token',
            'gross_amount' => 115000,
            'transaction_status' => 'pending',
        ]);

        $signatureKey = hash('sha512',
            'TOKOKU-TEST-003' .
            '200' .
            'cancel' .
            config('midtrans.server_key')
        );

        $this->postJson(route('payment.webhook'), [
            'order_id' => 'TOKOKU-TEST-003',
            'status_code' => '200',
            'transaction_status' => 'cancel',
            'transaction_id' => 'TX-CANCEL',
            'payment_type' => 'bank_transfer',
            'signature_key' => $signatureKey,
        ])->assertOk();

        $this->assertEquals('failed', $this->order->fresh()->payment_status);
    }
}
