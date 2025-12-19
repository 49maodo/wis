<?php

namespace App\Http\Controllers;

use App\Enums\SubscriptionStatus;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionOfferResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\SubscriptionOffer;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subscription::class);
    }

    /**
     * Display available subscription offers
     */
    public function offers(): JsonResponse
    {
        $offers = SubscriptionOffer::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => SubscriptionOfferResource::collection($offers),
        ]);
    }

    /**
     * Display recruiter's current subscription
     */
    public function index(): JsonResponse
    {
        $subscriptions = auth()->user()->subscriptions()
            ->with(['subscriptionOffer', 'payment'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => SubscriptionResource::collection($subscriptions),
        ]);
    }

    /**
     * Get current active subscription
     */
    public function current(): JsonResponse
    {
        $subscription = auth()->user()->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->with(['subscriptionOffer'])
            ->latest()
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SubscriptionResource($subscription),
        ]);
    }

    /**
     * Create a new subscription (BASIC only for now - no payment)
     */
    public function store(StoreSubscriptionRequest $request): JsonResponse
    {
        $offer = SubscriptionOffer::findOrFail($request->subscription_offer_id);

        // Only allow BASIC (free) subscriptions for now
        if (!$offer->isFree()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment integration is not available yet. Only BASIC subscription is allowed.',
            ], 403);
        }

        // Check if the recruiter already has an active subscription
        $existingSubscription = auth()->user()->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->exists();

        if ($existingSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription.',
            ], 422);
        }

        // Create subscription
        $subscription = Subscription::create([
            'recruiter_id' => auth()->user()->id,
            'subscription_offer_id' => $offer->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(), // BASIC is free for 1 year
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully.',
            'data' => new SubscriptionResource($subscription->load('subscriptionOffer')),
        ], 201);
    }

    /**
     * Renew subscription
     */
    public function renew(Subscription $subscription): JsonResponse
    {
        $this->authorize('renew', $subscription);

        // Only BASIC (free) for now
        if (!$subscription->subscriptionOffer->isFree()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment integration required for this subscription type.',
            ], 403);
        }

        $subscription->renew();

        return response()->json([
            'success' => true,
            'message' => 'Subscription renewed successfully.',
            'data' => new SubscriptionResource($subscription),
        ]);
    }

    /**
     * Suspend subscription
     */
    public function suspend(Subscription $subscription): JsonResponse
    {
        $this->authorize('suspend', $subscription);

        $subscription->suspend();

        // Deactivate all related job offers
        $subscription->subscriptionJobs()
            ->with('job')
            ->get()
            ->each(fn($sj) => $sj->job->update(['is_active' => false]));

        return response()->json([
            'success' => true,
            'message' => 'Subscription suspended successfully.',
            'data' => new SubscriptionResource($subscription),
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel(Subscription $subscription): JsonResponse
    {
        $this->authorize('cancel', $subscription);

        $subscription->cancel();

        // Deactivate all related job offers
        $subscription->subscriptionJobs()
            ->with('subscriptionJobs.job')
            ->get()
            ->each(fn($sj) => $sj->job->update(['is_active' => false]));

        return response()->json([
            'success' => true,
            'message' => 'Subscription cancelled successfully.',
            'data' => new SubscriptionResource($subscription),
        ]);
    }

    /**
     * Check subscription validity
     */
    public function checkValidity(Subscription $subscription): JsonResponse
    {
        $this->authorize('view', $subscription);

        return response()->json([
            'success' => true,
            'is_valid' => $subscription->checkValidity(),
            'remaining_days' => $subscription->calculateRemainingDays(),
            'remaining_quota' => $subscription->getRemainingQuota(),
        ]);
    }


}
