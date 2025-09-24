<?php

namespace App\Http\Requests;

use App\Enums\ExperienceLevel;
use App\Enums\JobType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'requirements' => ['nullable', 'array'],
            'salary' => ['nullable', 'numeric'],
            'experienceLevel' => ['required', Rule::enum(ExperienceLevel::class)],
            'location' => ['nullable'],
            'sector' => ['nullable'],
            'jobtype' => ['required', Rule::enum(JobType::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
