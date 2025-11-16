<?php

namespace App\Http\Requests\Client\Post;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => [ 'required', 'string', 'max:255' ],
            'profile_id' => [ 'required', 'integer', 'exists:profiles,id' ],
            'published_at' => [ 'required' ],
            'parent_comment_id' => [ 'nullable', 'integer', 'exists:comments,id' ]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'profile_id' => auth()->user()->profile->id,
            'published_at' => now()
        ]);
    }
}
