<?php

namespace App\Http\Requests\Api\Chat;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [ 'nullable', 'string' ],
            'profile_id' => [ 'nullable', 'integer', 'exists:profiles,id' ],
            'profile_login' => [ 'nullable', 'string' ]
        ];
    }
}
