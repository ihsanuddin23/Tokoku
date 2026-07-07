<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'seller_profile_id',
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value'               => 'decimal:2',
        'min_purchase'        => 'decimal:2',
        'max_discount'        => 'decimal:2',
        'starts_at'           => 'datetime',
        'expires_at'          => 'datetime',
        'is_active'           => 'boolean',
    ];

    public function sellerProfile(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function scopePlatformWide($query)
    {
        return $query->whereNull('seller_profile_id');
    }

    public function scopeForSeller($query, $sellerProfileId)
    {
        return $query->where(function ($q) use ($sellerProfileId) {
            $q->whereNull('seller_profile_id')->orWhere('seller_profile_id', $sellerProfileId);
        });
    }

    public function isSellerVoucher(): bool
    {
        return $this->seller_profile_id !== null;
    }

    public function isValid(float $subtotal): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if (! Carbon::now()->between($this->starts_at, $this->expires_at)) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        if ($subtotal < (float) $this->min_purchase) {
            return false;
        }
        return true;
    }

    public function calculateDiscount(float $subtotal, float $shippingCost = 0): float
    {
        if ($this->type === 'percentage') {
            $discount = $subtotal * ((float) $this->value / 100);
            if ($this->max_discount) {
                $discount = min($discount, (float) $this->max_discount);
            }
            return round($discount, 2);
        }

        if ($this->type === 'fixed') {
            return min((float) $this->value, $subtotal);
        }

        if ($this->type === 'free_shipping') {
            return $shippingCost;
        }

        return 0;
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'percentage'     => 'Persentase',
            'fixed'          => 'Nominal',
            'free_shipping'  => 'Gratis Ongkir',
            default          => $this->type,
        };
    }
}
