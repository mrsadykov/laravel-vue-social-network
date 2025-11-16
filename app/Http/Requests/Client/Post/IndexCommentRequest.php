<?php

namespace App\Http\Requests\Client\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => [ 'nullable', 'integer', 'min:10' ],
            'page' => [ 'nullable', 'integer', 'min:1' ],
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'per_page' => $this->per_page ?? 10,
            'page' => $this->page ?? 1,
        ]);
    }
}
