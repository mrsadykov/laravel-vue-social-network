<?php

namespace App\Http\Requests\Client\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => [ 'required', 'integer', 'exists:chats,id' ],
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ],
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'profile_id' => auth()->user()->profile->id
        ]);
    }
}
