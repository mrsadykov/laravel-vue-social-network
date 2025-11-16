<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreRequest extends FormRequest
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
        ];
    }

    // метод вызывается после валидации
    public function passedValidation()
    {
        /*if (isset($this->post['images']) && !empty($this->post['images'])) {
            $imagesPath = [];

            foreach ($this->post['images'] as $image) {
                $imagesPath[] = Storage::disk('public')->put('images', $image);
            }
        } */

        if (isset($this->images) && !empty($this->images)) {
            $imagesPath = [];

            foreach ($this->images as $image) {
                $imagesPath[] = Storage::disk('public')->put('images', $image);
            }
        }

        return $this->merge([
            'post' => [
                ...$this->validated()['post'],
                //'img_path' => Storage::disk('public')->put('images', $this->image),
                'profile_id' => auth()?->user()?->profile->id,
                'imagesPath' => $imagesPath ?? [],
            ],
            'tags' => explode(',', $this->validated()['tags'])
        ]);
    }
}
