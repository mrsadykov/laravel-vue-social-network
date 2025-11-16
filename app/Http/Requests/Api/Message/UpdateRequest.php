<?php

namespace App\Http\Requests\Api\Message;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => [ 'nullable', 'string' ],
        ];
    }

    public function messages(): array
    {
        return [
            'content.string' => 'Поле должно быть строковым',
        ];
    }
}
