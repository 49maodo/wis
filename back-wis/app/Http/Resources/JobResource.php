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
            'jobtype' => $this->jobtype,
            'creator' => $this->recruiter,
            'compagny' => $this->compagny,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
