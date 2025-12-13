<?php

namespace App\Http\Resources;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subscription */
class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'remaining_days' => $this->calculateRemainingDays(),
            'is_valid' => $this->checkValidity(),
            'used_quota' => $this->getUsedQuota(),
            'remaining_quota' => $this->getRemainingQuota(),
            'subscription_offer' => new SubscriptionOfferResource($this->whenLoaded('subscriptionOffer')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
