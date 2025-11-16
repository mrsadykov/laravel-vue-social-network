<?php

namespace App\Http\Requests\Client\Profile;

use Illuminate\Foundation\Http\FormRequest;

class IndexNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => [ 'required', 'integer', 'min:1' ],
            //'read_notification_ids' => [ 'nullable', 'array' ],
            //'read_notification_ids.*' => [ 'nullable', 'integer', 'exists:user_notifications,id' ]
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'page' => $this->page ?? 1
        ]);
    }
}
