<?php

namespace App\Http\Resources;

use App\Models\CompanyVerifications;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CompanyVerifications */
class CompagnyVerificationsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'ninea' => $this->ninea,
            'rccm' => $this->rccm,
            'notes' => $this->notes,
            'admin_notes' => $this->admin_notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'compagny_id' => $this->compagny_id,
            'submitted_by' => $this->submitted_by,

            'compagny' => new CompagnyResource($this->whenLoaded('compagny')),
        ];
    }
}
