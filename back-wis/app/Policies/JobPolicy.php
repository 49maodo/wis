<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Enums\VerificationStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Job $job): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if ($user->hasRole(UserRole::ADMIN)) {
            return true;
        }

        // Le recruteur doit avoir une entreprise validée
        if ($user->hasRole(UserRole::RECRUITER) && $user->compagny->status !== VerificationStatus::REJECTED) {
            $subscription = $user->recruiter->subscriptions()
                ->where('status', 'ACTIVE')
                ->latest()
                ->first();
            if (!$subscription || !$subscription->checkValidity()) {
                return false;
            }

            // Check quota
            return $subscription->getRemainingQuota() > 0 ||
                $subscription->subscriptionOffer->offer_type === 'UNLIMITED';
        }

        return false;
    }

    public function update(User $user, Job $job): bool
    {
        if ($user->hasRole(UserRole::ADMIN)) {
            return true;
        }
        // Le recruteur doit avoir une entreprise validée
        if ($user->hasRole(UserRole::RECRUITER) && $user->id === $job->creatorId && $user->compagny->is_verified) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Job $job): bool
    {
        if ($user->hasRole(UserRole::ADMIN)) {
            return true;
        }
        // Le recruteur doit avoir une entreprise validée
        if ($user->hasRole(UserRole::RECRUITER) && $user->id === $job->creatorId && $user->compagny->is_verified) {
            return true;
        }
        return false;
    }
    public function restore(User $user, Job $job): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function forceDelete(User $user, Job $job): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
