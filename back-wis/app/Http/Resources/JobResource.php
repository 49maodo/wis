<?php

namespace App\Http\Resources;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Job */
class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'salary' => $this->salary,
            'experienceLevel' => $this->experienceLevel,
            'location' => $this->location,
            'sector' => $this->sector,
            'jobtype' => $this->jobtype,
            'deadline' => $this->deadline,
            'creator' => $this->whenLoaded('recruiter'),
            'compagny' => new CompagnyResource($this->whenLoaded('compagny')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
