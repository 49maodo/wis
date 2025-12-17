<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CodeList extends Model
{
    protected $fillable = [
        'type',
        'value',
        'description',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    // Types de code disponibles
    public const TYPES = [
        'UserRole' => 'User Roles',
        'JobType' => 'Job Types',
        'Status' => 'Status',
        'ExperienceLevel' => 'Experience Levels',
        'PaymentStatus' => 'Payment Status',
        'OfferType' => 'Offer Types',
        'Location' => 'Locations',
        'Sector' => 'Sectors'
    ];


    protected static function booted()
    {
        // Vider le cache lors de modifications
        static::saved(function ($model) {
            Cache::forget("codelist_{$model->type}");
            Cache::forget('codelist_all');
        });

        static::deleted(function ($model) {
            Cache::forget("codelist_{$model->type}");
            Cache::forget('codelist_all');
        });
    }

    // Récupérer les valeurs par type (avec cache)
    public static function getByType(string $type, bool $activeOnly = true): array
    {
        if ($type === 'Skill') {
            return self::getSkillsFromTable($activeOnly);
        }

        $cacheKey = "codelist_{$type}" . ($activeOnly ? '_active' : '');

        return Cache::remember($cacheKey, 3600, function () use ($type, $activeOnly) {
            $query = self::where('type', $type);

            if ($activeOnly) {
                $query->where('active', true);
            }

            return $query->orderBy('value')
                ->get()
                ->map(fn($item) => [
                    'id' => $item->id,
                    'value' => $item->value,
                    'description' => $item->description,
                ])
                ->toArray();
        });
    }

    protected static function getSkillsFromTable(bool $activeOnly = true): array
    {
        $cacheKey = 'codelist_skills' . ($activeOnly ? '_active' : '');

        return Cache::remember($cacheKey, 3600, function () {
            return \App\Models\Skill::orderBy('name')
                ->get()
                ->map(fn($skill) => [
                    'id' => $skill->id,
                    'value' => $skill->name,
                    'description' => $skill->description ?? $skill->name,
                ])
                ->toArray();
        });
    }

    // Récupérer toutes les codelists (pour le frontend)
//    public static function getAllForFrontend(): array
//    {
//        return Cache::remember('codelist_all', 3600, function () {
//            $codelists = [];
//
//            foreach (array_keys(self::TYPES) as $type) {
//                $codelists[$type] = self::getByType($type);
//            }
//
//            $codelists['Skill'] = self::getSkillsFromTable();
//            return $codelists;
//        });
//    }
    public static function getAllForFrontend(): array
    {
        return Cache::remember('codelist_all', 3600, function () {
            $codelists = [];

            // Récupérer les types normaux depuis code_lists
            foreach (array_keys(self::TYPES) as $type) {
                $codelists[$type] = self::getByType($type);
            }

            // Ajouter les skills depuis la table skills
            $codelists['Skill'] = self::getSkillsFromTable();

            return $codelists;
        });
    }

    // Vider tout le cache
    public static function clearCache(): void
    {
        foreach (array_keys(self::TYPES) as $type) {
            Cache::forget("codelist_{$type}");
            Cache::forget("codelist_{$type}_active");
        }
        Cache::forget('codelist_all');
        Cache::forget('codelist_skills');
        Cache::forget('codelist_skills_active');
    }
}
