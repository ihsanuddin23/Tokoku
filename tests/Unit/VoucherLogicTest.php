<?php

namespace Tests\Unit;

use App\Models\Voucher;
use Tests\TestCase;

class VoucherLogicTest extends TestCase
{
    private function makeVoucher(array $overrides = []): Voucher
    {
        $voucher = new Voucher();
        $voucher->fill(array_merge([
            'code' => 'TEST123',
            'name' => 'Test Voucher',
            'type' => 'percentage',
            'value' => 10,
            'min_purchase' => 0,
            'max_discount' => null,
            'usage_limit' => null,
            'used_count' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addDay(),
            'is_active' => true,
            'seller_profile_id' => null,
        ], $overrides));

        return $voucher;
    }

    public function test_is_seller_voucher_returns_false_for_platform_wide(): void
    {
        $voucher = $this->makeVoucher(['seller_profile_id' => null]);
        $this->assertFalse($voucher->isSellerVoucher());
    }

    public function test_is_seller_voucher_returns_true_for_seller_specific(): void
    {
        $voucher = $this->makeVoucher(['seller_profile_id' => 1]);
        $this->assertTrue($voucher->isSellerVoucher());
    }

    public function test_is_valid_returns_true_for_active_voucher_in_date_range(): void
    {
        $voucher = $this->makeVoucher();
        $this->assertTrue($voucher->isValid(100000));
    }

    public function test_is_valid_returns_false_for_inactive_voucher(): void
    {
        $voucher = $this->makeVoucher(['is_active' => false]);
        $this->assertFalse($voucher->isValid(100000));
    }

    public function test_is_valid_returns_false_for_expired_voucher(): void
    {
        $voucher = $this->makeVoucher([
            'starts_at' => now()->subDays(10),
            'expires_at' => now()->subDay(),
        ]);
        $this->assertFalse($voucher->isValid(100000));
    }

    public function test_is_valid_returns_false_for_future_voucher(): void
    {
        $voucher = $this->makeVoucher([
            'starts_at' => now()->addDay(),
            'expires_at' => now()->addDays(10),
        ]);
        $this->assertFalse($voucher->isValid(100000));
    }

    public function test_is_valid_returns_false_when_usage_limit_reached(): void
    {
        $voucher = $this->makeVoucher([
            'usage_limit' => 100,
            'used_count' => 100,
        ]);
        $this->assertFalse($voucher->isValid(100000));
    }

    public function test_is_valid_returns_false_when_subtotal_below_min_purchase(): void
    {
        $voucher = $this->makeVoucher(['min_purchase' => 50000]);
        $this->assertFalse($voucher->isValid(25000));
    }

    public function test_is_valid_returns_true_when_subtotal_equals_min_purchase(): void
    {
        $voucher = $this->makeVoucher(['min_purchase' => 50000]);
        $this->assertTrue($voucher->isValid(50000));
    }

    public function test_calculate_discount_percentage(): void
    {
        $voucher = $this->makeVoucher([
            'type' => 'percentage',
            'value' => 10,
        ]);
        $this->assertEquals(10000, $voucher->calculateDiscount(100000));
    }

    public function test_calculate_discount_percentage_with_max_discount(): void
    {
        $voucher = $this->makeVoucher([
            'type' => 'percentage',
            'value' => 50,
            'max_discount' => 20000,
        ]);
        $this->assertEquals(20000, $voucher->calculateDiscount(100000));
    }

    public function test_calculate_discount_fixed(): void
    {
        $voucher = $this->makeVoucher([
            'type' => 'fixed',
            'value' => 25000,
        ]);
        $this->assertEquals(25000, $voucher->calculateDiscount(100000));
    }

    public function test_calculate_discount_fixed_capped_at_subtotal(): void
    {
        $voucher = $this->makeVoucher([
            'type' => 'fixed',
            'value' => 50000,
        ]);
        $this->assertEquals(30000, $voucher->calculateDiscount(30000));
    }

    public function test_calculate_discount_free_shipping(): void
    {
        $voucher = $this->makeVoucher([
            'type' => 'free_shipping',
            'value' => 0,
        ]);
        $this->assertEquals(15000, $voucher->calculateDiscount(100000, 15000));
    }

    public function test_calculate_discount_unknown_type_returns_zero(): void
    {
        $voucher = $this->makeVoucher(['type' => 'unknown']);
        $this->assertEquals(0, $voucher->calculateDiscount(100000));
    }

    public function test_get_type_label_attribute(): void
    {
        $this->assertEquals('Persentase', $this->makeVoucher(['type' => 'percentage'])->type_label);
        $this->assertEquals('Nominal', $this->makeVoucher(['type' => 'fixed'])->type_label);
        $this->assertEquals('Gratis Ongkir', $this->makeVoucher(['type' => 'free_shipping'])->type_label);
    }
}
