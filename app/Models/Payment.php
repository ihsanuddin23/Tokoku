<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'snap_token',
        'payment_type',
        'payment_channel',
        'gross_amount',
        'transaction_status',
        'fraud_status',
        'paid_at',
        'raw_response',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'raw_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSettled(): bool
    {
        return in_array($this->transaction_status, ['settlement', 'capture']);
    }

    public function isPending(): bool
    {
        return $this->transaction_status === 'pending';
    }

    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['deny', 'expire', 'cancel', 'failure']);
    }
}
