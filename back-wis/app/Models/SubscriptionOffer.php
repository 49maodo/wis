<?php

namespace App\Models;

use App\Enums\OfferType;
use Illuminate\Database\Eloquent\Model;

class SubscriptionOffer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'max_jobs',
        'offer_type',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'max_jobs' => 'integer',
        'offer_type' => OfferType::class,
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFeatures(): array
    {
        return match($this->offer_type) {
            OfferType::BASIC => [
                'featured_jobs' => false,
                'analytics' => false,
                'priority_support' => false,
            ],
            OfferType::PREMIUM => [
                'featured_jobs' => true,
                'analytics' => true,
                'priority_support' => true,
            ],
            OfferType::UNLIMITED => [
                'featured_jobs' => true,
                'analytics' => true,
                'priority_support' => true,
                'multi_recruiters' => true,
            ],
        };
    }

    public function isFree(): bool
    {
        return $this->offer_type === OfferType::BASIC;
    }
}
