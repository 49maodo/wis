<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true; // Tous les utilisateurs peuvent voir la liste des profils
    }

    public function view(User $user, Profile $profile)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Profile $profile)
    {
        return $user->id === $profile->user_id || $user->hasRole(UserRole::ADMIN);
    }

    public function delete(User $user, Profile $profile)
    {
        return $user->id === $profile->user_id || $user->hasRole(UserRole::ADMIN);
    }

    public function restore(User $user, Profile $profile)
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function forceDelete(User $user, Profile $profile)
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}
