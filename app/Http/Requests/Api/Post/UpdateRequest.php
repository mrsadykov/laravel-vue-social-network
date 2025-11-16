<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [ 'nullable', 'string', 'unique:posts,title' ],
            'content' => [ 'nullable', 'string' ],
            'img' => [ 'nullable', 'string' ],
            'video' => [ 'nullable', 'string' ],
            'published_at' => [ 'nullable', 'date_format:Y-m-d H:i:s' ],
            'category_id' => [ 'nullable', 'integer', 'exists:categories,id' ],
            'is_active' => [ 'nullable', 'boolean' ],
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'Заголовок должен быть уникальным',
            'title.string' => 'Поле должно быть строковым',
            'content.string' => 'Поле должно быть строковым',
            'img.string' => 'Поле должно быть строковым',
            'video.string' => 'Поле должно быть строковым',
            'published_at.date_format' => 'В поле должны быть дата и время',
            'is_active' => 'Поле должно быть булевым значением',
            'category_id.integer' => 'Поле должно быть числовым',
            'category_id.exists' => 'Категории не существует',
        ];
    }
}
