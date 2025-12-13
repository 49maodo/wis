<?php

namespace App\Http\Resources;

use App\Models\SubscriptionOffer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SubscriptionOffer */
class SubscriptionOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'max_jobs' => $this->max_jobs === -1 ? 'unlimited' : $this->max_jobs,
            'offer_type' => $this->offer_type,
            'is_free' => $this->isFree(),
            'features' => $this->getFeatures(),
            'is_active' => $this->is_active,
        ];
    }
}
