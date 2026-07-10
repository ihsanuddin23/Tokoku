<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'options',
        'price_adjustment',
        'stock',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'price_adjustment' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) $this->product->price + (float) $this->price_adjustment;
    }

    public function getFormattedPriceAdjustmentAttribute(): string
    {
        if ((float) $this->price_adjustment === 0.0) {
            return 'Gratis';
        }

        $sign = (float) $this->price_adjustment > 0 ? '+' : '-';

        return $sign . ' Rp ' . number_format(abs((float) $this->price_adjustment), 0, ',', '.');
    }

    public function getFormattedEffectivePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->effective_price, 0, ',', '.');
    }

    public function getOptionsLabelAttribute(): string
    {
        if (! $this->options) {
            return '';
        }

        return collect($this->options)
            ->map(fn ($value, $key) => ucfirst($key) . ': ' . $value)
            ->implode(' · ');
    }
}
