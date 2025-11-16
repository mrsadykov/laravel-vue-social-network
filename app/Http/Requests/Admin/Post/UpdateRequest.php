<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post.content' => [ 'required', 'string' ],
            'post.title' => [ 'required', 'string', 'max:255' ],
            'post.published_at' => [ 'nullable', 'date' ],
            'post.category_id' => [ 'nullable', 'integer', 'exists:categories,id' ],
            'images' => [ 'nullable', 'array' ],
            'images.*' => [ 'nullable', 'file', 'image' ],
            'tags' => [ 'nullable', 'string' ],
            'deletedImagesIds' => [ 'nullable', 'array' ],
        ];
    }

    /**
     * метод вызывается после валидации
     *
     * @return UpdateRequest|void
     */
    public function passedValidation()
    {
        if (isset($this->images) && !empty($this->images)) {
            $imagesPath = [];

            foreach ($this->images as $image) {
                $imagesPath[] = Storage::disk('public')->put('images', $image);
            }
        }

        return $this->merge([
            'post' => [
                ...$this->validated()['post'],
                'profile_id' => auth()?->user()?->profile->id,
                'imagesPath' => $imagesPath ?? [],
            ],
            'tags' => explode(',', $this->validated()['tags'])
        ]);
    }
}
