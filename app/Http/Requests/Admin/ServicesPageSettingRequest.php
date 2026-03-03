<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServicesPageSettingRequest extends FormRequest
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

            'section_badge' => 'required|string|max:255',
            'section_title' => 'required|string|max:500',
            'section_description' => 'required|string|max:5000',

            'block_1_badge' => 'required|string|max:255',
            'block_1_title' => 'required|string|max:500',
            'block_1_description' => 'required|string|max:5000',
            'block_1_button_text' => 'required|string|max:255',
            'block_1_button_url' => 'required|string|max:255',
            'block_1_image' => 'nullable|string|max:255',
            'block_1_image_file' => 'nullable|image|max:4096',

            'block_2_badge' => 'required|string|max:255',
            'block_2_title' => 'required|string|max:500',
            'block_2_description' => 'required|string|max:5000',
            'block_2_button_text' => 'required|string|max:255',
            'block_2_button_url' => 'required|string|max:255',
            'block_2_image' => 'nullable|string|max:255',
            'block_2_image_file' => 'nullable|image|max:4096',

            'catalog_title' => 'required|string|max:255',
            'catalog_description' => 'required|string|max:2000',
            'empty_state_text' => 'required|string|max:500',
        ];
    }
}
