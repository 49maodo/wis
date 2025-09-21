<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'resume',
        'social',
        'skills',
        'experiences',
        'education',
        'languages',
        'user_id',
    ];

    protected $casts = [
        'social' => 'array',
        'skills' => 'array',
        'experiences' => 'array',
        'education' => 'array',
        'languages' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
