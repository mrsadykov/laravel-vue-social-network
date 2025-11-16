<?php

namespace App\Http\Requests\Client\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ],
            'signature' => [ 'required', 'string', 'max:255' ],
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'profile_id' => auth()->user()->profile->id
        ]);
    }
}
