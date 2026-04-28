<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $featureImageRule = $this->isMethod('post')
            ? 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
            : 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:2000',
            'contact_information' => 'required|string|max:2000',
            'feature_image' => $featureImageRule,
            'google_map_location' => 'required|string|max:2000',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'existing_gallery_names' => 'nullable|array',
            'existing_gallery_names.*' => 'nullable|string|max:255',
            'delete_gallery_ids' => 'nullable|array',
            'delete_gallery_ids.*' => 'nullable|integer|exists:branch_gallery,id',
        ];
    }
}
