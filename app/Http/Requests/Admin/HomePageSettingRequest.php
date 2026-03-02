<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HomePageSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hero_badge' => 'nullable|array',
            'hero_badge.*' => 'nullable|string|max:120',
            'hero_title_html' => 'nullable|array',
            'hero_title_html.*' => 'nullable|string|max:1000',
            'hero_description' => 'nullable|array',
            'hero_description.*' => 'nullable|string|max:1000',
            'hero_button_text' => 'nullable|array',
            'hero_button_text.*' => 'nullable|string|max:120',
            'hero_button_url' => 'nullable|array',
            'hero_button_url.*' => 'nullable|string|max:255',
            'hero_existing_image' => 'nullable|array',
            'hero_existing_image.*' => 'nullable|string|max:255',
            'hero_image' => 'nullable|array',
            'hero_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'about.badge' => 'required|string|max:120',
            'about.title_html' => 'required|string|max:1000',
            'about.description' => 'required|string|max:1000',

            'stats.specialities_count' => 'required|string|max:30',
            'stats.specialities_label' => 'required|string|max:80',
            'stats.doctors_count' => 'required|string|max:30',
            'stats.doctors_label' => 'required|string|max:80',
            'stats.patients_count' => 'required|string|max:30',
            'stats.patients_label' => 'required|string|max:80',

            'our_approach.badge' => 'required|string|max:120',
            'our_approach.title_html' => 'required|string|max:1000',
            'our_approach.description_1' => 'required|string|max:1000',
            'our_approach.description_2' => 'required|string|max:1000',
            'our_approach.button_text' => 'required|string|max:120',
            'our_approach.button_url' => 'required|string|max:255',
            'our_approach.image' => 'nullable|string|max:255',
            'our_approach_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'lab_excellence.badge' => 'required|string|max:120',
            'lab_excellence.title_html' => 'required|string|max:1000',
            'lab_excellence.description' => 'required|string|max:1000',
            'lab_excellence.feature_1' => 'required|string|max:120',
            'lab_excellence.feature_2' => 'required|string|max:120',
            'lab_excellence.button_text' => 'required|string|max:120',
            'lab_excellence.button_url' => 'required|string|max:255',
            'lab_excellence.image' => 'nullable|string|max:255',
            'lab_excellence_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'experience_imperial.badge' => 'required|string|max:120',
            'experience_imperial.title_html' => 'required|string|max:1000',
            'experience_imperial.description' => 'required|string|max:1000',
            'experience_imperial.button_text' => 'required|string|max:120',
            'experience_imperial.button_url' => 'required|string|max:255',
            'experience_imperial.image' => 'nullable|string|max:255',
            'experience_imperial_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'continuous_care.title_html' => 'required|string|max:1000',
            'continuous_care.description' => 'required|string|max:1000',
            'continuous_care.button_text' => 'required|string|max:120',
            'continuous_care.button_url' => 'required|string|max:255',

            'expert_advice.title_html' => 'required|string|max:1000',
            'expert_advice.description' => 'required|string|max:1000',
            'expert_advice.button_text' => 'required|string|max:120',
            'expert_advice.button_url' => 'required|string|max:255',
        ];
    }
}
