<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    protected $fillable = [
        'slug',
        'resume',
        'social',
        'experiences',
        'education',
        'languages',
        'user_id',
    ];

    protected $casts = [
        'social' => 'array',
        'experiences' => 'array',
        'education' => 'array',
        'languages' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'profile_skills')
            ->withPivot(['level', 'id']);
    }
}
