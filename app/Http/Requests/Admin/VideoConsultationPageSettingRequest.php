<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VideoConsultationPageSettingRequest extends FormRequest
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

            'plans_section_title' => 'required|string|max:255',
            'plans_section_description' => 'required|string|max:2000',
            'plans_empty_text' => 'required|string|max:500',

            'why_title' => 'required|string|max:255',
            'why_image' => 'nullable|string|max:255',
            'why_image_file' => 'nullable|image|max:4096',
            'why_item_1' => 'required|string|max:500',
            'why_item_2' => 'required|string|max:500',
            'why_item_3' => 'required|string|max:500',
            'why_item_4' => 'required|string|max:500',
            'why_item_5' => 'required|string|max:500',

            'faq_title' => 'required|string|max:255',
            'faq_subtitle' => 'required|string|max:1000',
            'faq_1_question' => 'required|string|max:500',
            'faq_1_answer' => 'required|string|max:2000',
            'faq_2_question' => 'required|string|max:500',
            'faq_2_answer' => 'required|string|max:2000',
            'faq_3_question' => 'required|string|max:500',
            'faq_3_answer' => 'required|string|max:2000',
        ];
    }
}
