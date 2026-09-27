<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * MRAM SMS gateway (msg.mram.com.bd).
 *
 * Credentials live in the `sms` setting under gateways.mram, alongside the
 * Twilio and BulkSMSBD credentials. send() never throws, so a failed SMS can
 * never break the booking or notification that triggered it; every attempt is
 * logged so failures are traceable in storage/logs.
 */
class MramSmsService
{
    private const ENDPOINT = 'https://msg.mram.com.bd/smsapi';

    private string $apiKey;

    private string $senderId;

    private string $type;

    public function __construct(array $config)
    {
        $this->apiKey = trim((string) ($config['api_key'] ?? ''));
        $this->senderId = trim((string) ($config['sender_id'] ?? ''));
        $this->type = ($config['type'] ?? 'text') === 'unicode' ? 'unicode' : 'text';
    }

    public static function fromSettings(): self
    {
        $settings = setting('sms') ?: [];

        return new self($settings['gateways']['mram'] ?? []);
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== '' && $this->senderId !== '';
    }

    /**
     * Send one message to one or more numbers.
     *
     * @param  string|array<int, string>  $numbers
     * @return array{ok: bool, status: ?int, body: string}
     */
    public function send(string|array $numbers, string $message): array
    {
        $contacts = $this->formatContacts($numbers);

        // Bangla (or any non-ASCII) text is garbled when sent as `text`.
        $type = preg_match('/[^\x00-\x7F]/', $message) === 1 ? 'unicode' : $this->type;

        $context = ['contacts' => $contacts, 'type' => $type];

        if (! $this->isConfigured()) {
            Log::error('MRAM SMS Error', $context + ['error' => 'MRAM SMS gateway is not configured']);

            return ['ok' => false, 'status' => null, 'body' => 'MRAM SMS gateway is not configured'];
        }

        if ($contacts === '') {
            Log::error('MRAM SMS Error', $context + ['error' => 'No valid recipient number']);

            return ['ok' => false, 'status' => null, 'body' => 'No valid recipient number'];
        }

        try {
            // Form-encoded body, so special characters in msg (&, $, @, Bangla)
            // are URL-encoded correctly.
            $response = Http::asForm()->timeout(15)->post(self::ENDPOINT, [
                'api_key' => $this->apiKey,
                'type' => $type,
                'contacts' => $contacts,
                'senderid' => $this->senderId,
                'msg' => $message,
                'label' => 'transactional',
            ]);

            $body = trim($response->body());
            // MRAM reports failures as a numeric error code (e.g. "1002") with HTTP 200.
            $ok = $response->successful() && preg_match('/^\s*10\d\d\b/', $body) !== 1;

            $logContext = $context + ['status' => $response->status(), 'response' => $body];
            $ok ? Log::info('MRAM SMS Response', $logContext) : Log::error('MRAM SMS Error', $logContext);

            return ['ok' => $ok, 'status' => $response->status(), 'body' => $body];
        } catch (\Throwable $e) {
            Log::error('MRAM SMS Error', $context + ['error' => $e->getMessage()]);

            return ['ok' => false, 'status' => null, 'body' => $e->getMessage()];
        }
    }

    /**
     * Normalise to 8801XXXXXXXXX and join multiple numbers with "+".
     *
     * @param  string|array<int, string>  $numbers
     */
    private function formatContacts(string|array $numbers): string
    {
        $numbers = is_array($numbers) ? $numbers : preg_split('/[+,;\s]+/', $numbers);

        return collect($numbers)
            ->map(function ($number) {
                $digits = preg_replace('/\D+/', '', (string) $number);

                if (preg_match('/^01\d{9}$/', $digits) === 1) {
                    $digits = '88'.$digits;
                }

                return $digits;
            })
            ->filter()
            ->unique()
            ->implode('+');
    }
}
