<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookingNotificationSettingRequest extends FormRequest
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
        return [
            // present (not required) so that clearing every row is a valid,
            // explicit "notify nobody" rather than a validation failure.
            'booking_notification_emails' => 'present|array|max:20',
            // nullable per row: the form always renders one input per entry and
            // an admin may add a row and leave it blank. ConvertEmptyStringsToNull
            // is in the global middleware stack, so a blank row arrives as null
            // and passes, while a half-typed address still fails. Validating per
            // row (rather than on a joined string) is what lets the error render
            // against the exact input the admin got wrong.
            'booking_notification_emails.*' => 'nullable|string|email:rfc|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'booking_notification_emails' => 'booking notification recipients',
            'booking_notification_emails.*' => 'booking notification recipient',
        ];
    }
}
