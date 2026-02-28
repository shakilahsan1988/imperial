<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $info;
    public $emails;

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
        $this->info = setting('info');
        $this->emails = setting('emails');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Login OTP - Imperial Health')
                    ->view('emails.patient_otp')
                    ->with([
                        'otp' => $this->otp,
                        'info' => $this->info,
                        'emails' => $this->emails
                    ]);
    }
}
