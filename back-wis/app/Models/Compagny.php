<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Compagny extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo',
        'website',
        'location',
        'owner_id',
    ];
    public function recruiters()
    {
        return $this->hasMany(User::class)->where('role', UserRole::RECRUITER);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function verifications()
    {
        return $this->hasOne(CompagnyVerifications::class);
    }

    public function isVerified(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->verifications?->status === VerificationStatus::APPROVED
        );
    }

    public function invitations()
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function pendingInvitations()
    {
        return $this->hasMany(CompanyInvitation::class)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now());
    }

}
