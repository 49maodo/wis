<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected static function booted()
    {
        // Vider le cache des skills lors de modifications
        static::saved(function () {
            Cache::forget('codelist_skills');
            Cache::forget('codelist_skills_active');
            Cache::forget('codelist_all');
        });

        static::deleted(function () {
            Cache::forget('codelist_skills');
            Cache::forget('codelist_skills_active');
            Cache::forget('codelist_all');
        });
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_skills')
            ->withPivot('level');
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_skill', 'skill_id', 'job_id');
    }
    // Récupérer toutes les skills formatées pour les codelists
    public static function getForCodeList(): array
    {
        return Cache::remember('codelist_skills', 3600, function () {
            return self::orderBy('name')
                ->get()
                ->map(fn($skill) => [
                    'id' => $skill->id,
                    'value' => $skill->name,
                    'description' => $skill->description ?? $skill->name,
                ])
                ->toArray();
        });
    }
}
