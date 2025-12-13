<?php

namespace App\Models;

use App\Enums\ExperienceLevel;
use App\Enums\JobType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'salary',
        'experienceLevel',
        'location',
        'sector',
        'jobtype',
        'creatorId',
        'compagny_id',
        'deadline',
    ];

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creatorId');
    }

    public function skills() : BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'job_skill')
            ->withPivot(['level', 'id']);
    }

    protected function casts(): array
    {
        return [
            'experienceLevel' => ExperienceLevel::class,
            'jobtype' => JobType::class,
            'deadline' => 'date',
        ];
    }


    /**
     * @return Job|HasMany
     */
    public function applications() : HasMany|Job
    {
        return $this->hasMany(Application::class);
    }
}
