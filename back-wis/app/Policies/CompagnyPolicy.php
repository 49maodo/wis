<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Compagny;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompagnyPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Compagny $compagny)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasRole(UserRole::ADMIN) || ($user->hasRole(UserRole::RECRUITER) && !$user->compagny_id);
    }

    public function update(User $user, Compagny $compagny)
    {
        return $user->hasRole(UserRole::ADMIN) || $compagny->owner_id === $user->id;
    }

    public function delete(User $user, Compagny $compagny)
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function restore(User $user, Compagny $compagny)
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function forceDelete(User $user, Compagny $compagny)
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
