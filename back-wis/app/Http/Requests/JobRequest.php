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
            'skills' => ['nullable', 'array'],
            'skills.*.skill_id' => ['required_with:skills', 'integer', 'exists:skills,id'],
            'skills.*.level' => [
                'required_with:skills',
                'string',
                Rule::enum(ExperienceLevel::class)
            ],
            'salary' => ['nullable', 'numeric'],
            'experienceLevel' => ['required', Rule::enum(ExperienceLevel::class)],
            'location' => ['nullable'],
            'sector' => ['nullable'],
            'jobtype' => ['required', Rule::enum(JobType::class)],
            'deadline' => ['nullable', 'date', 'after:today'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
