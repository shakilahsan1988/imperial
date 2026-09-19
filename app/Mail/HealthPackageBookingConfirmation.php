<?php

namespace App\Mail;

use App\Models\HealthPackageBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HealthPackageBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(HealthPackageBooking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Health Package Booking Confirmation - Imperial Health Bangladesh',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.health-package-booking-confirmation',
        );
    }
}
