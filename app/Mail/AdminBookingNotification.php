<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $type  One of: booking, health_package, membership_plan, doctor_consultation
     */
    public function __construct(
        public string $type,
        public $booking,
    ) {
    }

    public function envelope(): Envelope
    {
        $labels = [
            'booking' => 'Lab/Diagnostic Booking',
            'health_package' => 'Health Package Booking',
            'membership_plan' => 'Membership Plan Booking',
            'doctor_consultation' => 'Doctor Appointment Booking',
        ];

        return new Envelope(
            subject: 'New '.($labels[$this->type] ?? 'Booking').' - Imperial Health',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-booking-notification',
            with: [
                'typeLabel' => $this->typeLabel(),
                'rows' => $this->buildRows(),
            ],
        );
    }

    private function typeLabel(): string
    {
        return match ($this->type) {
            'booking' => 'Lab/Diagnostic Booking',
            'health_package' => 'Health Package Booking',
            'membership_plan' => 'Membership Plan Booking',
            'doctor_consultation' => 'Doctor Appointment Booking',
            default => 'Booking',
        };
    }

    /**
     * Treat both null and empty string as "no value" - many of these fields
     * (email in particular) come through as '' rather than null.
     */
    private function dash($value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    }

    /**
     * Build a flat label => value list for the email, since each booking
     * type carries a different shape of data.
     */
    private function buildRows(): array
    {
        $b = $this->booking;

        $base = [
            'Patient Name' => $b->patient_name,
            'Phone' => $this->dash($b->phone ?? $b->patient_phone ?? null),
            'Email' => $this->dash($b->email ?? $b->patient_email ?? null),
            'Age' => $this->dash($b->age ?? null),
        ];

        return match ($this->type) {
            'booking' => $base + [
                'Services' => $b->services->pluck('name')->implode(', ') ?: '-',
                'Visit Type' => $b->booking_type === 'home_visit' ? 'Home Visit' : 'Branch Visit',
                'Branch' => optional($b->branch)->title ?: optional($b->branch)->name ?: '-',
                'Scheduled Date' => optional($b->scheduled_date)->format('d M Y') ?: (string) $b->scheduled_date,
                'Scheduled Time' => $b->scheduled_time ? $b->scheduled_time->format('h:i A') : '-',
                'Total Amount' => formated_price($b->total_amount),
            ],
            'health_package' => $base + [
                'Package' => optional($b->package)->name ?: '-',
                'Preferred Date' => optional($b->preferred_date)->format('d M Y') ?: '-',
                'Total Amount' => formated_price($b->total_amount),
            ],
            'membership_plan' => $base + [
                'Plan' => optional($b->plan)->name ?: '-',
                'Preferred Start Date' => optional($b->preferred_start_date)->format('d M Y') ?: '-',
                'Total Amount' => formated_price($b->total_amount),
            ],
            'doctor_consultation' => $base + [
                'Doctor' => optional($b->doctor)->name ?: '-',
                'Visit Type' => $b->visit_type === 'video' ? 'Online Video Consultation' : 'In-Hub Visit',
                'Branch' => $b->visit_type === 'in_hub' ? (optional($b->branch)->title ?: optional($b->branch)->name ?: '-') : '-',
                'Appointment Date' => optional($b->appointment_date)->format('d M Y') ?: (string) $b->appointment_date,
                'Slot' => $b->time_label ?: '-',
                'Consultation Fee' => formated_price($b->consultation_fee),
            ],
            default => $base,
        };
    }
}
