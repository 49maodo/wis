<?php

namespace App\Models;

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
        return $this->hasMany(User::class)->where('role', 'RECRUITER');
    }
}
