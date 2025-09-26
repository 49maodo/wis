<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Model;

class Compagny extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo',
        'website',
        'location',
    ];
    public function recruiters()
    {
        return $this->hasMany(User::class)->where('role', UserRole::RECRUITER);
    }
}
