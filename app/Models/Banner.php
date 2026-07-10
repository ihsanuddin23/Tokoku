<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Banner extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'image_path',
        'link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('home:banners');
        });

        static::deleted(function () {
            Cache::forget('home:banners');
        });
    }
}
