<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Compagny extends Model
{
    protected $fillable = [
        'ninea',
        'rccm',
        'status',
        'name',
        'description',
        'logo',
        'website',
        'location',
    ];

    protected $casts = [
        'status' => VerificationStatus::class,
    ];
    public function recruiters()
    {
        return $this->hasMany(User::class)->where('role', UserRole::RECRUITER);
    }

    public function isVerified(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === VerificationStatus::APPROVED
        );
    }

    /*
    public function invitations()
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function pendingInvitations()
    {
        return $this->hasMany(CompanyInvitation::class)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now());
    }*/

}
