<?php

namespace App\Http\Resources;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Application */
class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'cv' => $this->cv,
            'status' => $this->status,
            'job' => $this->whenLoaded('job'),
            'candidat' => $this->whenLoaded('candidat'),
            'compagny' => $this->whenLoaded('compagny'),
            'profile' => $this->whenLoaded('candidat.profile'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
