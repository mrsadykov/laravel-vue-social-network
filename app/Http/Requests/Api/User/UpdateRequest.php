<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [ 'nullable', 'string' ],
            'email' => [ 'nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id ],
            'password' => [ 'nullable', 'string', 'min:8' ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Поле должно быть строковым',
            'email.string' => 'Поле должно быть строковым',
            'email.unique' => 'Пользователь с таким адресом электронной почтой уже существует',
            'email.email' => 'В поле должен быть адрес электронной почты',
        ];
    }
}
