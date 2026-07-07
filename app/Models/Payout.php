<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model
{
    protected $fillable = [
        'seller_profile_id',
        'payout_number',
        'amount',
        'fee',
        'net_amount',
        'status',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'admin_note',
        'processed_at',
        'completed_at',
        'order_ids',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'fee'          => 'decimal:2',
        'net_amount'   => 'decimal:2',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'order_ids'    => 'array',
    ];

    public function sellerProfile(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu',
            'processing' => 'Diproses',
            'completed'  => 'Selesai',
            'rejected'   => 'Ditolak',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-700',
            'processing' => 'bg-blue-100 text-blue-700',
            'completed'  => 'bg-green-100 text-green-700',
            'rejected'   => 'bg-red-100 text-red-700',
            default      => 'bg-dark-100 text-dark-600',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }

    public function getFormattedNetAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->net_amount, 0, ',', '.');
    }
}
