<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Compagny;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompagnyPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @return true
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Compagny $compagny): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN) || ($user->hasRole(UserRole::RECRUITER) && !$user->compagny_id);
    }

    public function update(User $user, Compagny $compagny): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $compagny->id === $user->compagny_id;
    }

    public function delete(User $user, Compagny $compagny): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function restore(User $user, Compagny $compagny): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function forceDelete(User $user, Compagny $compagny): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
