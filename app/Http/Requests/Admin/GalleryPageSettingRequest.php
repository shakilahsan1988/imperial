<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryPageSettingRequest extends FormRequest
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
            'gallery_groups' => 'nullable|array',
            'gallery_groups.*.id' => 'nullable|integer|exists:gallery_groups,id',
            'gallery_groups.*.name' => 'required|string|max:255',
            'gallery_groups.*.delete_group' => 'nullable|boolean',
            'gallery_groups.*.existing_images' => 'nullable|array',
            'gallery_groups.*.existing_images.*.id' => 'nullable|integer|exists:gallery_images,id',
            'gallery_groups.*.existing_images.*.name' => 'nullable|string|max:255',
            'gallery_groups.*.existing_images.*.delete' => 'nullable|boolean',
            'gallery_groups.*.new_images' => 'nullable|array',
            'gallery_groups.*.new_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }
}
