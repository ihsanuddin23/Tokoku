<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreFollower extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'seller_profile_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class);
    }
}
