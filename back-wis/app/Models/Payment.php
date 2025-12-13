<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'response_details',
        'paid_at',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    protected function casts(): array
    {
        return [
            'paid_at' => 'timestamp',
        ];
    }
}
