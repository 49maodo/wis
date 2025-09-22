<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::USER) && $user->id === $application->candidat_id) ||
            ($user->hasRole(UserRole::RECRUITER) && $user->compagny && $user->id === $application->job->creatorId);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::USER);
    }

    public function update(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::RECRUITER) && $user->id === $application->job->creatorId && $user->compagny);
    }

    public function delete(User $user, Application $application): bool
    {
        return  $user->hasRole(UserRole::ADMIN) ||
            ($user->hasRole(UserRole::USER) && $user->id === $application->candidat_id);
    }

    public function restore(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
