<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
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
     * Normalise contact details before validation. Empty strings become null,
     * email casing is made consistent, and phone numbers retain their entered
     * country-code format because doctors may intentionally share one contact.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->normalizeEmail($this->input('email')),
            'phone' => $this->normalizePhone($this->input('phone')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Doctor names identify public profiles and remain unique. Contact
        // details are intentionally shareable (for example, a central desk).
        $doctorId = $this->route('doctor');

        $uploads = (array) config('doctor_sync.uploads', []);
        $allowedTypes = (array) ($uploads['allowed_types'] ?? []);
        $extensions = implode(',', array_keys($allowedTypes));
        $mimeTypes = implode(',', array_unique(array_values($allowedTypes)));

        return [
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('doctors')->ignore($doctorId)->whereNull('deleted_at'),
            ],

            'email' => [
                'nullable',
                'email:rfc',
                'max:191',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:191',
            ],

            'doctor_specialty_id' => 'required|exists:doctor_specialties,id',
            'doctor_department_id' => 'required|exists:doctor_departments,id',
            'address' => 'required',
            'commission' => 'required|numeric|min:0|max:100',
            'consultation_fee' => 'required|numeric|min:0',
            'video_consultation_fee' => 'required_if:video_consultation_available,1|nullable|numeric|min:0',
            'experience_years' => 'nullable|integer|min:0|max:60',

            // `mimes` checks the extension, `mimetypes` sniffs the actual
            // content. Both are needed: the filename is attacker-controlled,
            // the bytes are not.
            'image' => [
                'nullable',
                'image',
                'mimes:'.$extensions,
                'mimetypes:'.$mimeTypes,
                'max:'.($uploads['max_kilobytes'] ?? 5120),
                sprintf(
                    'dimensions:min_width=%d,min_height=%d,max_width=%d,max_height=%d',
                    $uploads['min_width'] ?? 200,
                    $uploads['min_height'] ?? 200,
                    $uploads['max_width'] ?? 4000,
                    $uploads['max_height'] ?? 4000
                ),
            ],
            'remove_image' => 'nullable|boolean',

            'branch_schedules' => 'nullable|array',
            'branch_schedules.*.branch_id' => 'required|exists:branches,id|distinct',
            'branch_schedules.*.enabled' => 'nullable|boolean',
            'branch_schedules.*.consultant' => 'nullable|string|max:255',
            'branch_schedules.*.schedule_days' => 'nullable|string|max:255',
            'branch_schedules.*.schedule_time' => 'nullable|string|max:255',
        ];
    }

    /**
     * Lower-case an email address, or null it when blank.
     */
    protected function normalizeEmail($value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = strtolower(trim($value));

        return $value === '' ? null : $value;
    }

    /**
     * Trim a phone number while preserving its country-code notation.
     */
    protected function normalizePhone($value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
