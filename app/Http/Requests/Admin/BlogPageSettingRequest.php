<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogPageSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_name' => 'required|string|max:255',
            'hero_title_html' => 'required|string|max:2000',
            'hero_description' => 'required|string|max:5000',
            'hero_image' => 'nullable|string|max:255',
            'hero_image_file' => 'nullable|image|max:4096',

            'founder_badge' => 'required|string|max:255',
            'founder_title' => 'required|string|max:500',
            'founder_description' => 'required|string|max:8000',
            'founder_button_text' => 'required|string|max:255',
            'founder_button_url' => 'required|string|max:255',
            'founder_image' => 'nullable|string|max:255',
            'founder_image_file' => 'nullable|image|max:4096',

            'blog_list_title' => 'required|string|max:255',
            'blogs_per_page' => 'required|integer|min:1|max:50',
        ];
    }
}
