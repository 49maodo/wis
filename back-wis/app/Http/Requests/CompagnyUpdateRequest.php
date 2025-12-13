<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompagnyUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ninea' => ['sometimes', 'string', 'max:255'],
            'rccm' => ['sometimes', 'string', 'max:255'],
            'name' => ['sometimes', 'string', 'max:255', 'unique:compagnies,name,'.$this->compagny?->id],
            'description' => ['sometimes', 'max:255'],
            'website' => ['sometimes', 'url'],
            'location' => ['sometimes', 'string', 'max:255'],
            'logo' => ['sometimes', 'image', 'max:2048'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
