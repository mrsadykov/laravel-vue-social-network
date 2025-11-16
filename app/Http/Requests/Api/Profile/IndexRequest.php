<?php

namespace App\Http\Requests\Api\Profile;

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
            'second_name' => [ 'nullable', 'string' ],
            'third_name' => [ 'nullable', 'string' ],
            'city' => [ 'nullable', 'string' ],
            'login' => [ 'nullable', 'string' ],
            'post_id' => [ 'nullable', 'integer', 'exists:posts,id' ],
            'user_id' => [ 'nullable', 'integer', 'exists:users,id' ],
            'chat_id' => [ 'nullable', 'integer', 'exists:chats,id' ]
        ];
    }
}
