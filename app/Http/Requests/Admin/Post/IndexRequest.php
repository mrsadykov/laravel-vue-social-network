<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [ 'nullable', 'string' ],
            'content' => [ 'nullable', 'string' ],
            'views_from' => [ 'nullable', 'integer', 'min:0' ],
            'published_at_from' => [ 'nullable', 'date_format:Y-m-d' ],
            'published_at_to' => [ 'nullable', 'date_format:Y-m-d' ],
            'category_id' => [ 'nullable', 'integer', 'exists:categories,id' ],
            'category_title' => [ 'nullable', 'string' ],
            'profile_id' => [ 'nullable', 'integer', 'exists:profiles,id' ],
            'per_page' => [ 'nullable', 'integer', 'min:10' ],
            'page' => [ 'nullable', 'integer', 'min:1' ],
        ];
    }

    // метод вызывается до валидации
    /*public function prepareForValidation()
    {
        return $this->merge([
            'per_page' => $this->per_page ?? 10,
            'page' => $this->page ?? 1
        ]);
    }*/

    // метод вызывается после валидации
    public function passedValidation()
    {
        return $this->merge([
            'per_page' => $this->per_page ?? 10,
            'page' => $this->page ?? 1
        ]);
    }
}
