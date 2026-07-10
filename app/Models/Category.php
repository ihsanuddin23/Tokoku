<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (! $category->slug) {
                $slug = Str::slug($category->name);
                $original = $slug;
                $counter = 1;
                while (Category::where('slug', $slug)->exists()) {
                    $slug = $original . '-' . $counter++;
                }
                $category->slug = $slug;
            }
        });

        static::updating(function (Category $category) {
            if ($category->isDirty('name') && ! $category->isDirty('slug')) {
                $slug = Str::slug($category->name);
                $original = $slug;
                $counter = 1;
                while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                    $slug = $original . '-' . $counter++;
                }
                $category->slug = $slug;
            }
        });

        static::saved(function () {
            Cache::forget('categories:active');
        });

        static::deleted(function () {
            Cache::forget('categories:active');
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function cachedActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('categories:active', now()->addHours(6), function () {
            return static::where('is_active', true)->orderBy('name')->get();
        });
    }

}
