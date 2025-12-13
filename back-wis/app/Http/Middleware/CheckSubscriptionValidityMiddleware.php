<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscriptionValidityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'RECRUITER') {
            return $next($request);
        }

        $subscription = $request->user()->subscriptions()
            ->where('status', 'ACTIVE')
            ->latest()
            ->first();

        if (!$subscription || !$subscription->checkValidity()) {
            return response()->json([
                'success' => false,
                'message' => 'Your subscription has expired or is invalid. Please renew your subscription.',
            ], 403);
        }

        // Add a subscription to request for easy access
        $request->merge(['current_subscription' => $subscription]);

        return $next($request);
    }
}
