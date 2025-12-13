<?php

namespace App\Http\Requests;

use App\Enums\SubscriptionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::enum(SubscriptionStatus::class)],
            'end_date' => ['sometimes', 'date', 'after:start_date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
