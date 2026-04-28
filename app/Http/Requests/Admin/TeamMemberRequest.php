<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:200',
            'branch_id' => 'nullable|exists:branches,id',
            'designation' => 'required|string|max:200',
            'bio' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:1',
        ];

        if ($this->team_member) {
            $rules['name'] = [
                'required',
                'string',
                'max:200',
                Rule::unique('team_members')->ignore($this->team_member),
            ];
        } else {
            $rules['name'] = 'required|string|max:200|unique:team_members,name';
        }

        return $rules;
    }
}
