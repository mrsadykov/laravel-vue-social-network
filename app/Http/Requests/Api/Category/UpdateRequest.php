<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [ 'nullable', 'string', 'unique:categories,title,' . $this->category->id ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Поле должно быть строковым',
            'title.unique' => 'Заголовок должен быть уникальным'
        ];
    }
}
