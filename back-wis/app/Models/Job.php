<?php

namespace App\Models;

use App\Enums\ExperienceLevel;
use App\Enums\JobType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'salary',
        'experienceLevel',
        'location',
        'jobtype',
        'creatorId',
        'compagny_id',
    ];

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creatorId');
    }

    public function compagny(): BelongsTo
    {
        return $this->belongsTo(Compagny::class);
    }

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'experienceLevel' => ExperienceLevel::class,
            'jobtype' => JobType::class,
        ];
    }
}
