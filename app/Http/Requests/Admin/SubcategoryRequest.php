<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubcategoryRequest extends FormRequest
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
        $subcategory = $this->route('subcategory');
        $subcategoryId = is_object($subcategory) ? $subcategory->id : $subcategory;

        return [
            'language' => ['required', 'string', 'in:bn,en'],
            'parent_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->whereNull('parent_id')
            ],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($subcategoryId)
            ],
            'description' => ['nullable', 'string'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }
}
