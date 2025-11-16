<?php

namespace App\Http\Requests\Api\Comment;

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
            'content' => [ 'nullable', 'string' ],
            'published_at_from' => [ 'nullable', 'date_format:Y-m-d' ],
            'published_at_to' => [ 'nullable', 'date_format:Y-m-d' ],
            'profile_id' => [ 'nullable', 'integer', 'exists:profiles,id' ],
            'profile_login' => [ 'nullable', 'string' ],
            'post_id' => [ 'nullable', 'integer', 'exists:posts,id' ],
            'post_title' => [ 'nullable', 'string' ]
        ];
    }
}
