<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, Profile $profile)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, Profile $profile)
    {
    }

    public function delete(User $user, Profile $profile)
    {
    }

    public function restore(User $user, Profile $profile)
    {
    }

    public function forceDelete(User $user, Profile $profile)
    {
    }
}
