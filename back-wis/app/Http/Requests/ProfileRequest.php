<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'resume' => ['required'],
            'social' => ['nullable'],
            'skills' => ['nullable'],
            'experiences' => ['nullable'],
            'education' => ['nullable'],
            'languages' => ['nullable'],
            'user_id' => ['required', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
