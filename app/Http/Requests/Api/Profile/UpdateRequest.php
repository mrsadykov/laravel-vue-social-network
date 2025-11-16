<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'second_name' => [ 'nullable', 'string' ],
            'third_name' => [ 'nullable', 'string' ],
            'avatar' => [ 'nullable', 'string' ],
            'city' => [ 'nullable', 'string' ],
            'login' => [ 'nullable', 'string' ],
        ];
    }

    public function messages(): array
    {
        return [
            'second_name.string' => 'Поле должно быть строковым',
            'third_name.string' => 'Поле должно быть строковым',
            'avatar.string' => 'Поле должно быть строковым',
            'city.string' => 'Поле должно быть строковым',
            'login.string' => 'Поле должно быть строковым',
        ];
    }
}
