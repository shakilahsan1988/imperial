<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SslCommerzSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|string|max:255',
            'store_password' => 'required|string|max:255',
            'sandbox_mode' => 'nullable',
            'enabled' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'store_id.required' => 'Store ID is required.',
            'store_password.required' => 'Store Password is required.',
        ];
    }
}
