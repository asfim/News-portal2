<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
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
        $news = $this->route('news');
        $newsId = is_object($news) ? $news->id : $news;

        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'integer', 'exists:categories,id'],
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news', 'slug')->ignore($newsId)
            ],
            'short_description' => ['required', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'integer', 'exists:media,id'],
            'thumbnail' => ['nullable', 'integer', 'exists:media,id'],
            'video_url' => ['nullable', 'string', 'max:255'],
            'video_upload' => ['nullable', 'mimes:mp4,webm,ogg', 'max:51200'], // 50MB max
            'source_name' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'url', 'max:255'],
            
            // Flags
            'breaking_news' => ['nullable', 'boolean'],
            'featured_news' => ['nullable', 'boolean'],
            'trending_news' => ['nullable', 'boolean'],
            'editor_choice' => ['nullable', 'boolean'],
            'is_latest' => ['nullable', 'boolean'],
            
            // Gallery
            'gallery_images' => ['nullable', 'array', 'max:4'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            
            
            // Status and Date
            'status' => ['required', 'string', Rule::in(['draft', 'pending', 'approved', 'published', 'scheduled', 'rejected', 'archived'])],
            'publish_at' => ['nullable', 'date'],
            
            // SEO
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            
            // Tags (Array of tag ids)
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }
}
