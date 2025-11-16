<?php

namespace App\Http\Requests\Api\Tag;

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
            'post_id' => [ 'nullable', 'integer', 'exists:posts,id' ],
            'post_title' => [ 'nullable', 'string' ]
        ];
    }
}
