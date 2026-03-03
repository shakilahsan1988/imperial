<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutPageSettingRequest extends FormRequest
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

            'intro_title' => 'required|string|max:500',
            'intro_description' => 'required|string|max:5000',
            'intro_image' => 'nullable|string|max:255',
            'intro_image_file' => 'nullable|image|max:4096',

            'feature_1_title' => 'required|string|max:255',
            'feature_1_desc' => 'required|string|max:2000',
            'feature_2_title' => 'required|string|max:255',
            'feature_2_desc' => 'required|string|max:2000',
            'feature_3_title' => 'required|string|max:255',
            'feature_3_desc' => 'required|string|max:2000',

            'leadership_title' => 'required|string|max:255',
            'leadership_description' => 'required|string|max:2000',
            'partners_title' => 'required|string|max:255',
            'partners_subtitle' => 'required|string|max:500',
        ];
    }
}
