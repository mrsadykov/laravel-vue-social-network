<?php

namespace App\Http\Requests\Client\Chat;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_ids' => [ 'required', 'array', 'min:2' ],
            'profile_ids.*' => [ 'required', 'integer', 'exists:profiles,id' ]
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'profile_ids' => array_merge(
                $this->profile_ids,
                [ auth()->user()->profile->id ]
            )
        ]);
    }
}
