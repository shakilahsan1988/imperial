<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if($this->doctor)
        {
            return [
                'name'=>[
                    'required',
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'email'=>[
                    'required',
                    'email',
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'phone'=>[
                    'required',
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'doctor_specialty_id' => 'required|exists:doctor_specialties,id',
                'doctor_department_id' => 'required|exists:doctor_departments,id',
                'address'=>'required',
                'commission'=>'required|numeric|min:0|max:100',
                'consultation_fee' => 'required|numeric|min:0',
                'video_consultation_fee' => 'required_if:video_consultation_available,1|nullable|numeric|min:0',
                'experience_years' => 'nullable|integer|min:0|max:60',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'branch_schedules' => 'nullable|array',
                'branch_schedules.*.branch_id' => 'required|exists:branches,id|distinct',
                'branch_schedules.*.enabled' => 'nullable|boolean',
                'branch_schedules.*.consultant' => 'nullable|string|max:255',
                'branch_schedules.*.schedule_days' => 'nullable|string|max:255',
                'branch_schedules.*.schedule_time' => 'nullable|string|max:255',
            ];
        }
        else{
            return [
                'name'=>[
                    'required',
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'email'=>[
                    'required',
                    'email',
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'phone'=>[
                    'required',
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'doctor_specialty_id' => 'required|exists:doctor_specialties,id',
                'doctor_department_id' => 'required|exists:doctor_departments,id',
                'address'=>'required',
                'commission'=>'required|numeric|min:0|max:100',
                'consultation_fee' => 'required|numeric|min:0',
                'video_consultation_fee' => 'required_if:video_consultation_available,1|nullable|numeric|min:0',
                'experience_years' => 'nullable|integer|min:0|max:60',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'branch_schedules' => 'nullable|array',
                'branch_schedules.*.branch_id' => 'required|exists:branches,id|distinct',
                'branch_schedules.*.enabled' => 'nullable|boolean',
                'branch_schedules.*.consultant' => 'nullable|string|max:255',
                'branch_schedules.*.schedule_days' => 'nullable|string|max:255',
                'branch_schedules.*.schedule_time' => 'nullable|string|max:255',
            ];
        }

       
    }
}
