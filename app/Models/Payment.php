<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'provider', 'transaction_id', 'amount_cents', 'currency',
        'status', 'failure_reason', 'card_brand', 'card_last4',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}