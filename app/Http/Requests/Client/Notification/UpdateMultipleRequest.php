<?php

namespace App\Http\Requests\Client\Notification;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMultipleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ]
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'profile_id' => auth()->user()->profile->id
        ]);
    }
}
