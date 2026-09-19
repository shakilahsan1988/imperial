<?php

namespace App\Mail;

use App\Models\DoctorConsultationBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DoctorConsultationBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(DoctorConsultationBooking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Confirmation - Imperial Health Bangladesh',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.doctor-consultation-booking-confirmation',
        );
    }
}
