<?php

namespace App\Http\Resources;

use App\Models\Compagny;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Compagny */
class CompagnyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'location' => $this->location,
            'logo' => $this->logo ? url(Storage::url($this->logo)) : null,
            'recruiters' => $this->whenLoaded('recruiters'),
            'isVerified' => $this->is_verified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
