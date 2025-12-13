<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subscription_offer_id' => ['required', 'exists:subscription_offers,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
