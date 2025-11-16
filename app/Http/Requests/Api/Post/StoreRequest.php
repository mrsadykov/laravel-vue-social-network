<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [ 'required', 'string', 'unique:posts,title' ],
            'content' => [ 'required', 'string' ],
            'img' => [ 'nullable', 'string' ],
            'video' => [ 'nullable', 'string' ],
            'published_at' => [ 'nullable', 'date_format:Y-m-d H:i:s' ],
            'category_id' => [ 'required', 'integer', 'exists:categories,id' ],
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ],
            'is_active' => [ 'nullable', 'boolean' ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле обязательное для заполнения',
            'title.unique' => 'Заголовок должен быть уникальным',
            'title.string' => 'Поле должно быть строковым',
            'content.required' => 'Поле обязательное для заполнения',
            'content.string' => 'Поле должно быть строковым',
            'img.string' => 'Поле должно быть строковым',
            'video.string' => 'Поле должно быть строковым',
            'published_at.date_format' => 'В поле должны быть дата и время',
            'is_active' => 'Поле должно быть булевым значением',
            'profile_id.required' => 'Поле обязательное для заполнения',
            'profile_id.integer' => 'Поле должно быть числовым',
            'profile_id.exists' => 'Профиля не существует',
            'category_id.required' => 'Поле обязательное для заполнения',
            'category_id.integer' => 'Поле должно быть числовым',
            'category_id.exists' => 'Категории не существует',
        ];
    }
}
