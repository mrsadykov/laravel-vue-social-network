<?php

namespace App\Http\Requests\Api\Tag;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [ 'nullable', 'string', 'unique:tags,title,' . $this->id ],
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
