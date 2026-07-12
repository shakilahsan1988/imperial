<?php

namespace App\Services;

use App\Models\DoctorConsultationBooking;
use App\Models\SslCommerzTransaction;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslCommerzService
{
    protected array $credentials;
    protected bool $sandbox;
    protected bool $enabled;

    public function __construct()
    {
        $this->loadConfig();
    }

    public function loadConfig(): void
    {
        $config = setting('sslcommerz') ?? [];
        $this->credentials = $config;
        $this->sandbox = ($config['sandbox_mode'] ?? true) === true || ($config['sandbox_mode'] ?? true) === '1';
        $this->enabled = ($config['enabled'] ?? false) === true || ($config['enabled'] ?? false) === '1';
    }

    public function isEnabled(): bool
    {
        return $this->enabled
            && !empty($this->credentials['store_id'])
            && !empty($this->credentials['store_password']);
    }

    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    public function getApiBaseUrl(): string
    {
        return $this->sandbox
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';
    }

    public function getCurrency(): string
    {
        $info = setting('info');
        return $info['currency'] ?? 'BDT';
    }

    public function getSuccessUrl(): string
    {
        return route('payment.success');
    }

    public function getFailUrl(): string
    {
        return route('payment.fail');
    }

    public function getCancelUrl(): string
    {
        return route('payment.cancel');
    }

    public function getIpnUrl(): string
    {
        return route('payment.ipn');
    }

    /**
     * Initiate payment session with SSLCommerz
     */
    public function initiatePayment(DoctorConsultationBooking $booking): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'message' => 'SSLCommerz payment gateway is not configured or disabled.',
            ];
        }

        $tranId = 'DCB-' . $booking->id . '-' . time();
        $amount = number_format((float) $booking->consultation_fee, 2, '.', '');
        $currency = $this->getCurrency();
        $patientName = $booking->patient_name;
        $patientEmail = $booking->email;
        $patientPhone = $booking->phone;

        $post_data = [
            'store_id' => $this->credentials['store_id'],
            'store_passwd' => $this->credentials['store_password'],
            'total_amount' => $amount,
            'currency' => $currency,
            'tran_id' => $tranId,
            'success_url' => $this->getSuccessUrl(),
            'fail_url' => $this->getFailUrl(),
            'cancel_url' => $this->getCancelUrl(),
            'ipn_url' => $this->getIpnUrl(),
            'emi_option' => 0,
            'cus_name' => $patientName,
            'cus_email' => $patientEmail,
            'cus_add1' => '',
            'cus_add2' => '',
            'cus_city' => '',
            'cus_state' => '',
            'cus_postcode' => '',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $patientPhone,
            'cus_fax' => '',
            'ship_name' => $patientName,
            'ship_add1' => '',
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => 'Bangladesh',
            'shipping_method' => 'NO',
            'product_name' => 'Doctor Consultation - ' . ($booking->doctor->name ?? 'N/A'),
            'product_category' => 'Consultation',
            'product_profile' => 'service',
            'value_a' => (string) $booking->id,
            'value_b' => 'consultation',
            'value_c' => '',
            'value_d' => '',
        ];

        // Log the init attempt
        SslCommerzTransaction::create([
            'consultation_booking_id' => $booking->id,
            'transaction_id' => $tranId,
            'amount' => $amount,
            'currency' => $currency,
            'status' => 'init',
        ]);

        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post($this->getApiBaseUrl() . '/gwprocess/v4/api.php', $post_data);

            $body = $response->json();

            Log::info('SSLCommerz Session Response', [
                'tran_id' => $tranId,
                'status' => $body['status'] ?? 'unknown',
                'response' => $body,
            ]);

            if (isset($body['status']) && $body['status'] === 'SUCCESS') {
                return [
                    'success' => true,
                    'transaction_id' => $tranId,
                    'session_key' => $body['sessionkey'] ?? '',
                    'gateway_url' => $body['GatewayPageURL'] ?? ($this->getApiBaseUrl() . '/gwprocess/v4/gw.php?Q=PAY&SESSIONKEY=' . ($body['sessionkey'] ?? '')),
                ];
            }

            return [
                'success' => false,
                'message' => $body['failedreason'] ?? $body['redirecturl'] ?? 'Failed to create payment session.',
                'transaction_id' => $tranId,
            ];
        } catch (\Exception $e) {
            Log::error('SSLCommerz Initiation Error', [
                'tran_id' => $tranId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment gateway connection error. Please try again.',
                'transaction_id' => $tranId,
            ];
        }
    }

    /**
     * Validate payment via SSLCommerz validation API
     */
    public function validatePayment(string $valId): array
    {
        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post($this->getApiBaseUrl() . '/validator/api/validationserverAPI.php', [
                    'val_id' => $valId,
                    'store_id' => $this->credentials['store_id'],
                    'store_passwd' => $this->credentials['store_password'],
                    'v' => 1,
                    'format' => 'json',
                ]);

            $body = $response->json();

            Log::info('SSLCommerz Validation Response', [
                'val_id' => $valId,
                'status' => $body['status'] ?? 'unknown',
            ]);

            if (isset($body['status']) && $body['status'] === 'VALID') {
                return [
                    'success' => true,
                    'transaction_id' => $body['tran_id'] ?? '',
                    'bank_transaction_id' => $body['bank_tran_id'] ?? '',
                    'amount' => $body['amount'] ?? 0,
                    'currency' => $body['currency'] ?? 'BDT',
                    'card_type' => $body['card_type'] ?? '',
                    'card_no' => $body['card_no'] ?? '',
                    'bank_gateway' => $body['bank_gateway'] ?? '',
                    'validation_id' => $valId,
                    'status' => $body['status'] ?? '',
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment validation failed.',
                'data' => $body,
            ];
        } catch (\Exception $e) {
            Log::error('SSLCommerz Validation Error', [
                'val_id' => $valId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment validation connection error.',
            ];
        }
    }
}
