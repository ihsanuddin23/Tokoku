<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'order_item_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'refunded' => 'Dana Dikembalikan',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-blue-100 text-blue-700',
            'rejected' => 'bg-red-100 text-red-700',
            'refunded' => 'bg-green-100 text-green-700',
            default    => 'bg-dark-100 text-dark-600',
        };
    }
}
