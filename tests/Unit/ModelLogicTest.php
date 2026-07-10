<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Tests\TestCase;

class ModelLogicTest extends TestCase
{
    public function test_order_can_be_paid_when_pending_and_unpaid(): void
    {
        $order = new Order();
        $order->status = 'pending';
        $order->payment_status = 'unpaid';

        $this->assertTrue($order->canBePaid());
    }

    public function test_order_cannot_be_paid_when_already_paid(): void
    {
        $order = new Order();
        $order->status = 'paid';
        $order->payment_status = 'paid';

        $this->assertFalse($order->canBePaid());
    }

    public function test_order_cannot_be_paid_when_cancelled(): void
    {
        $order = new Order();
        $order->status = 'cancelled';
        $order->payment_status = 'unpaid';

        $this->assertFalse($order->canBePaid());
    }

    public function test_order_can_be_cancelled_when_pending(): void
    {
        $order = new Order();
        $order->status = 'pending';
        $order->payment_status = 'unpaid';

        $this->assertTrue($order->canBeCancelled());
    }

    public function test_order_can_be_cancelled_when_paid(): void
    {
        $order = new Order();
        $order->status = 'paid';
        $order->payment_status = 'paid';

        $this->assertTrue($order->canBeCancelled());
    }

    public function test_order_cannot_be_cancelled_when_completed(): void
    {
        $order = new Order();
        $order->status = 'completed';
        $order->payment_status = 'paid';

        $this->assertFalse($order->canBeCancelled());
    }

    public function test_order_cannot_be_cancelled_when_refunded(): void
    {
        $order = new Order();
        $order->status = 'paid';
        $order->payment_status = 'refunded';

        $this->assertFalse($order->canBeCancelled());
    }

    public function test_order_status_badge_mapping(): void
    {
        $order = new Order();

        $order->status = 'pending';
        $this->assertEquals('bg-amber-100 text-amber-700', $order->status_badge);

        $order->status = 'paid';
        $this->assertEquals('bg-blue-100 text-blue-700', $order->status_badge);

        $order->status = 'shipped';
        $this->assertEquals('bg-indigo-100 text-indigo-700', $order->status_badge);

        $order->status = 'completed';
        $this->assertEquals('bg-green-100 text-green-700', $order->status_badge);

        $order->status = 'cancelled';
        $this->assertEquals('bg-red-100 text-red-700', $order->status_badge);
    }

    public function test_order_status_label_mapping(): void
    {
        $order = new Order();

        $order->status = 'pending';
        $this->assertEquals('Menunggu Pembayaran', $order->status_label);

        $order->status = 'paid';
        $this->assertEquals('Dibayar', $order->status_label);

        $order->status = 'shipped';
        $this->assertEquals('Dikirim', $order->status_label);

        $order->status = 'completed';
        $this->assertEquals('Selesai', $order->status_label);

        $order->status = 'cancelled';
        $this->assertEquals('Dibatalkan', $order->status_label);
    }

    public function test_order_formatted_subtotal(): void
    {
        $order = new Order();
        $order->subtotal = 150000;

        $this->assertEquals('Rp 150.000', $order->formatted_subtotal);
    }

    public function test_order_formatted_grand_total(): void
    {
        $order = new Order();
        $order->grand_total = 1750000;

        $this->assertEquals('Rp 1.750.000', $order->formatted_grand_total);
    }

    public function test_product_formatted_price(): void
    {
        $product = new Product();
        $product->price = 99000;

        $this->assertEquals('Rp 99.000', $product->formatted_price);
    }

    public function test_product_formatted_price_large_value(): void
    {
        $product = new Product();
        $product->price = 5000000;

        $this->assertEquals('Rp 5.000.000', $product->formatted_price);
    }

    public function test_product_first_image_returns_null_when_empty(): void
    {
        $product = new Product();
        $product->images = [];

        $this->assertNull($product->first_image);
    }

    public function test_product_first_image_returns_first_element(): void
    {
        $product = new Product();
        $product->images = ['products/img1.jpg', 'products/img2.jpg'];

        $this->assertEquals('products/img1.jpg', $product->first_image);
    }

    public function test_product_condition_label_new(): void
    {
        $product = new Product();
        $product->condition = 'new';

        $this->assertEquals('Baru', $product->condition_label);
    }

    public function test_product_condition_label_used(): void
    {
        $product = new Product();
        $product->condition = 'used';

        $this->assertEquals('Bekas', $product->condition_label);
    }

    public function test_variant_effective_price_with_positive_adjustment(): void
    {
        $product = new Product();
        $product->price = 100000;

        $variant = new ProductVariant();
        $variant->product = $product;
        $variant->price_adjustment = 25000;

        $this->assertEquals(125000, $variant->effective_price);
    }

    public function test_variant_effective_price_with_zero_adjustment(): void
    {
        $product = new Product();
        $product->price = 100000;

        $variant = new ProductVariant();
        $variant->product = $product;
        $variant->price_adjustment = 0;

        $this->assertEquals(100000, $variant->effective_price);
    }

    public function test_variant_formatted_price_adjustment_zero(): void
    {
        $variant = new ProductVariant();
        $variant->price_adjustment = 0;

        $this->assertEquals('Gratis', $variant->formatted_price_adjustment);
    }

    public function test_variant_formatted_price_adjustment_positive(): void
    {
        $variant = new ProductVariant();
        $variant->price_adjustment = 25000;

        $this->assertEquals('+ Rp 25.000', $variant->formatted_price_adjustment);
    }

    public function test_variant_formatted_price_adjustment_negative(): void
    {
        $variant = new ProductVariant();
        $variant->price_adjustment = -10000;

        $this->assertEquals('- Rp 10.000', $variant->formatted_price_adjustment);
    }

    public function test_variant_formatted_effective_price(): void
    {
        $product = new Product();
        $product->price = 100000;

        $variant = new ProductVariant();
        $variant->product = $product;
        $variant->price_adjustment = 50000;

        $this->assertEquals('Rp 150.000', $variant->formatted_effective_price);
    }

    public function test_variant_options_label_with_options(): void
    {
        $variant = new ProductVariant();
        $variant->options = ['color' => 'red', 'size' => 'XL'];

        $this->assertEquals('Color: red · Size: XL', $variant->options_label);
    }

    public function test_variant_options_label_without_options(): void
    {
        $variant = new ProductVariant();
        $variant->options = null;

        $this->assertEquals('', $variant->options_label);
    }
}
