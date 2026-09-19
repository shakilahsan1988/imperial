<?php

namespace App\Mail;

use App\Models\MembershipPlanBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipPlanBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(MembershipPlanBooking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Membership Plan Booking Confirmation - Imperial Health Bangladesh',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.membership-plan-booking-confirmation',
        );
    }
}
