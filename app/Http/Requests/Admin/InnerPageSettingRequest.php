<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InnerPageSettingRequest extends FormRequest
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
        ];
    }
}

