<?php

namespace App\Http\Requests\Api\Chat;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [ 'required', 'string', 'unique:chats,title' ],
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле обязательное для заполнения',
            'title.string' => 'Поле должно быть строковым',
            'title.unique' => 'Заголовок должен быть уникальным',
            'profile_id.required' => 'Поле обязательное для заполнения',
            'profile_id.integer' => 'Поле должно быть числовым',
            'profile_id.exists' => 'Профиля не существует'
        ];
    }
}
