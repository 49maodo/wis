<?php

namespace App\Http\Requests;

use App\Enums\ApplicationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:1000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            'job_id' => ['required', 'exists:jobs,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
