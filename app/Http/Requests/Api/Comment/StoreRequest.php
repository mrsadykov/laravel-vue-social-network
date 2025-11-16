<?php

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => [ 'required', 'string' ],
            'published_at' => [ 'required', 'date_format:Y-m-d H:i:s' ],
            'post_id' => [ 'required', 'integer', 'exists:posts,id' ],
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ]
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Поле обязательное для заполнения',
            'content.string' => 'Поле должно быть строковым',
            'published_at.required' => 'Поле обязательное для заполнения',
            'published_at.date_format' => 'В поле должны быть дата и время',
            'post_id.required' => 'Поле обязательное для заполнения',
            'post_id.integer' => 'Поле должно быть числовым',
            'post_id.exists' => 'Статьи не существует',
            /*'commentable.id' => '',
            'commentable.type' => '',*/
            'profile_id.required' => 'Поле обязательное для заполнения',
            'profile_id.integer' => 'Поле должно быть числовым',
            'profile_id.exists' => 'Профиля не существует'
        ];
    }
}
