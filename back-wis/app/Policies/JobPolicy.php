<?php

namespace App\Policies;

use App\Enums\UserRole;
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
        return $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::RECRUITER) && $user->compagny);
    }

    public function update(User $user, Job $job): bool
    {
        return $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::RECRUITER) and $user->id === $job->creatorId && $user->compagny);
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::RECRUITER) and $user->id === $job->creatorId && $user->compagny);
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
