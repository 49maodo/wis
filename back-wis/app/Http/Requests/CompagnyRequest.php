<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompagnyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:compagnies,name,'.$this->compagny?->id],
            'description' => ['nullable', 'max:255'],
            'website' => ['nullable', 'url'],
            'location' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
