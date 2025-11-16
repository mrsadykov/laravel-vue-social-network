<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [ 'required', 'string', 'unique:categories,title' ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле обязательное для заполнения',
            'title.string' => 'Поле должно быть строковым',
            'title.unique' => 'Заголовок должен быть уникальным'
        ];
    }
}
