<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HealthCheckPageSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page_name' => 'required|string|max:120',
            'hero_title_html' => 'required|string|max:1200',
            'hero_description' => 'required|string|max:1200',
            'hero_image' => 'nullable|string|max:255',
            'hero_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'feature_1_title' => 'required|string|max:120',
            'feature_1_desc' => 'required|string|max:255',
            'feature_2_title' => 'required|string|max:120',
            'feature_2_desc' => 'required|string|max:255',
            'feature_3_title' => 'required|string|max:120',
            'feature_3_desc' => 'required|string|max:255',

            'faq_title' => 'required|string|max:120',
            'faq_subtitle' => 'required|string|max:255',
            'faq_1_question' => 'required|string|max:255',
            'faq_1_answer' => 'required|string|max:1000',
            'faq_2_question' => 'required|string|max:255',
            'faq_2_answer' => 'required|string|max:1000',
            'faq_3_question' => 'required|string|max:255',
            'faq_3_answer' => 'required|string|max:1000',
        ];
    }
}
