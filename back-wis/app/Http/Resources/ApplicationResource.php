<?php

namespace App\Http\Resources;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Application */
class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'cv' => $this->cv ? url(Storage::url($this->cv)) : null,
            'status' => $this->status,
            'job' => new JobResource($this->whenLoaded('job')),
            'candidat' => $this->whenLoaded('candidat'),
            'compagny' => new CompagnyResource($this->whenLoaded('compagny')),
            'profile' => new ProfileResource($this->whenLoaded('candidat.profile')),
            'skills' => $this->whenLoaded('candidat.profile.skills'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
