<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sku',
        'weight',
        'condition',
        'status',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? Str::slug($product->name) . '-' . Str::random(6);
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') && ! $product->isDirty('slug')) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(6);
            }
        });
    }

    public function sellerProfile(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$term}%"))
              ->orWhereHas('sellerProfile', fn ($s) => $s->where('store_name', 'like', "%{$term}%"));
        });
    }

    public function getFirstImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getConditionLabelAttribute(): string
    {
        return $this->condition === 'new' ? 'Baru' : 'Bekas';
    }
}
