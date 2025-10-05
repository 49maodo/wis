<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CompagnyVerifications;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompagnyVerificationsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CompagnyVerifications $companyVerifications): bool
    {
        return $user->id == $companyVerifications->submitted_by;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::RECRUITER) && $user->compagny_id && !$user->compagny->is_verified;
    }
}
