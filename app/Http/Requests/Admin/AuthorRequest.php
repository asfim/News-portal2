<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $authorId = $this->route('author')?->id;

        return [
            'user_id' => [
                'nullable',
                'integer',
                Rule::unique('authors', 'user_id')->ignore($authorId)
            ],
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('authors', 'username')->ignore($authorId)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('authors', 'email')->ignore($authorId)
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'profile_photo_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'designation' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'linkedin' => ['nullable', 'url'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
