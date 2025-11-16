<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [ 'required', 'string' ],
            'email' => [ 'required', 'string', 'email', 'max:255', 'unique:users,email' ],
            'password' => [ 'required', 'string', 'min:8' ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательное для заполнения',
            'name.string' => 'Поле должно быть строковым',
            'email.required' => 'Поле обязательное для заполнения',
            'email.string' => 'Поле должно быть строковым',
            'email.unique' => 'Пользователь с таким адресом электронной почтой уже существует',
            'email.email' => 'В поле должен быть адрес электронной почты',
            'password.required' => 'Поле обязательное для заполнения',
        ];
    }
}
