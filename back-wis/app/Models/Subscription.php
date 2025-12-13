<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'recruiter_id',
        'subscription_offer_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => SubscriptionStatus::class,
    ];

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id', 'id');
    }

    public function subscriptionOffer()
    {
        return $this->belongsTo(SubscriptionOffer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function subscriptionJobs()
    {
        return $this->hasMany(SubscriptionJob::class);
    }

    // Business Logic Methods
    public function checkValidity(): bool
    {
        return $this->end_date >= now() &&
            $this->status === SubscriptionStatus::ACTIVE;
    }

    public function calculateRemainingDays(): int
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function renew()
    {
        $this->end_date = now()->addMonths(1);
        $this->status = SubscriptionStatus::ACTIVE;
        $this->save();
    }

    public function cancel()
    {
        $this->status = SubscriptionStatus::CANCELLED;
        $this->save();
    }

    public function suspend()
    {
        $this->status = SubscriptionStatus::SUSPENDED;
        $this->save();
    }

    public function getUsedQuota(): int
    {
        return $this->subscriptionJobs()
            ->whereHas('job', fn($q) => $q->where('is_active', true))
            ->count();
    }

    public function getRemainingQuota(): int
    {
        return $this->subscriptionOffer->max_jobs - $this->getUsedQuota();
    }
}
