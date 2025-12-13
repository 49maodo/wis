<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionJob extends Model
{
    protected $fillable = [
        'used_quota',
        'assigned_date',
        'subscription_id',
        'job_id',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    protected function casts(): array
    {
        return [
            'assigned_date' => 'datetime',
        ];
    }
}
