<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SmsSettingRequest extends FormRequest
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
            'active_gateway' => 'required|in:mram,bulksmsbd',

            'gateways.bulksmsbd.api_key' => 'required_if:active_gateway,bulksmsbd',
            'gateways.bulksmsbd.sender_id' => 'required_if:active_gateway,bulksmsbd',

            'gateways.mram.api_key' => 'required_if:active_gateway,mram',
            'gateways.mram.sender_id' => 'required_if:active_gateway,mram',
            'gateways.mram.type' => 'nullable|in:text,unicode',

            'patient_code.message'=>'regex:/{patient_code}/|regex:/{patient_name}/',
            'tests_notification.message'=>'regex:/{patient_code}/|regex:/{patient_name}/'
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
            'active_gateway' => 'active SMS gateway',
            'gateways.bulksmsbd.api_key' => 'BulkSMSBD API key',
            'gateways.bulksmsbd.sender_id' => 'BulkSMSBD sender ID',
            'gateways.mram.api_key' => 'MRAM SMS API key',
            'gateways.mram.sender_id' => 'MRAM SMS sender ID',
            'gateways.mram.type' => 'MRAM SMS default type',
            'patient_code.message' => 'Patient code sms message',
            'tests_notification.message' => 'Tests notification sms message',
        ];
    }
}
