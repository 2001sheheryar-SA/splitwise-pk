<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => [ 'required','file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'], //max 5 mb
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'An image file is required.',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'The image must be a jpg, jpeg, png, gif, or webp file.',
            'image.max' => 'The image may not be larger than 5MB.',
        ];
    }
}
