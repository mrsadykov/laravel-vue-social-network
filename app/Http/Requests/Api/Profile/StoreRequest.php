<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'second_name' => [ 'nullable', 'string' ],
            'third_name' => [ 'nullable', 'string' ],
            'avatar' => [ 'nullable', 'string' ],
            'city' => [ 'nullable', 'string' ],
            'login' => [ 'required', 'string' ],
            'user_id' => [ 'required', 'integer', 'exists:users,id' ],
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
            'login.required' => 'Поле обязательное для заполнения',
            'user_id.required' => 'Поле обязательное для заполнения',
            'user_id.integer' => 'Поле должно быть строковым',
            'user_id.exists' => 'Пользователь не существует'
        ];
    }
}
