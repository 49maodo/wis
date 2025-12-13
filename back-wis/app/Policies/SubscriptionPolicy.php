<?php

namespace App\Policies;

use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->hasRole(UserRole::RECRUITER);
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->id === $subscription->recruiter_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->hasRole(UserRole::RECRUITER);
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->id === $subscription->recruiter_id &&
            $subscription->status !== SubscriptionStatus::CANCELLED->value;
    }

    public function renew(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->recruiter_id;
    }

    public function cancel(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->recruiter_id &&
            in_array($subscription->status, [SubscriptionStatus::ACTIVE->value, SubscriptionStatus::SUSPENDED->value]);
    }

    public function suspend(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->recruiter_id &&
            $subscription->status === SubscriptionStatus::ACTIVE->value;
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function restore(User $user, Subscription $subscription): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->hasRole(UserRole::RECRUITER);
    }

    public function forceDelete(User $user, Subscription $subscription): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
