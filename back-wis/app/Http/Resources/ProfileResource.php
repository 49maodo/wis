<?php

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/** @mixin Profile */
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'resume' => $this->resume,
            'social_links' => $this->formatSocialLinks(),
            'skills' => $this->formatSkills(),
            'experiences' => $this->formatExperiences(),
            'education' => $this->formatEducation(),
            'languages' => $this->formatLanguages(),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function formatSocialLinks()
    {
        if (!$this->social_links) {
            return [];
        }

        return collect($this->social_links)->map(function ($link) {
            return [
                'platform' => $link['platform'] ?? null,
                'url' => $link['url'] ?? null,
            ];
        });
    }

    private function formatSkills()
    {
        if (!$this->skills) {
            return [];
        }

        return collect($this->skills)->map(function ($skill) {
            return [
                'name' => $skill['name'] ?? null,
                'level' => $skill['level'] ?? null,
                'category' => $skill['category'] ?? null,
            ];
        });
    }

    private function formatExperiences()
    {
        if (!$this->experiences) {
            return [];
        }

        return collect($this->experiences)->map(function ($experience) {
            return [
                'title' => $experience['title'] ?? null,
                'company' => $experience['company'] ?? null,
                'location' => $experience['location'] ?? null,
                'start_date' => $experience['start_date'] ?? null,
                'end_date' => $experience['end_date'] ?? null,
                'current' => $experience['current'] ?? false,
                'description' => $experience['description'] ?? null,
                'type' => $experience['type'] ?? null,
                'duration' => $this->calculateDuration($experience['start_date'] ?? null, $experience['end_date'] ?? null, $experience['current'] ?? false),
            ];
        });
    }

    private function formatEducation()
    {
        if (!$this->education) {
            return [];
        }

        return collect($this->education)->map(function ($edu) {
            return [
                'degree' => $edu['degree'] ?? null,
                'institution' => $edu['institution'] ?? null,
                'field_of_study' => $edu['field_of_study'] ?? null,
                'start_date' => $edu['start_date'] ?? null,
                'end_date' => $edu['end_date'] ?? null,
                'current' => $edu['current'] ?? false,
                'grade' => $edu['grade'] ?? null,
                'description' => $edu['description'] ?? null,
            ];
        });
    }

    private function formatLanguages()
    {
        if (!$this->languages) {
            return [];
        }

        return collect($this->languages)->map(function ($language) {
            return [
                'language' => $language['language'] ?? null,
                'level' => $language['level'] ?? null,
                'certification' => $language['certification'] ?? null,
            ];
        });
    }

    private function calculateDuration($startDate, $endDate, $current)
    {
        if (!$startDate) {
            return null;
        }

        $start = new \DateTime($startDate);
        $end = $current ? new \DateTime() : ($endDate ? new \DateTime($endDate) : null);

        if (!$end) {
            return null;
        }

        $interval = $start->diff($end);
        $years = $interval->y;
        $months = $interval->m;

        if ($years > 0) {
            return $months > 0 ? "{$years} an(s) et {$months} mois" : "{$years} an(s)";
        }

        return $months > 0 ? "{$months} mois" : "Moins d'un mois";
    }
}
