<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'shortcut' => ['required', 'string', 'max:50'],
            'sample_type' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'precautions' => ['nullable', 'string'],
            'component' => ['required', 'array', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'component.required' => __('At least one component is required.'),
        ];
    }
}
