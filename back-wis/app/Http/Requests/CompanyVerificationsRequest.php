<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyVerificationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'compagny_id' => ['required', 'exists:compagnies,id'],
            'ninea' => ['required'],
            'rccm' => ['nullable'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
