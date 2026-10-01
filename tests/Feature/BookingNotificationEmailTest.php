<?php

namespace Tests\Feature;

use App\Mail\AdminBookingNotification;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorConsultationSlot;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

/**
 * Who receives the internal "new booking" email.
 *
 * Covers both halves of the feature: the admin form that stores the recipient
 * list, and the booking flow that mails it. The recipients are read from the
 * settings table at send time, so these tests drive the real POST and then assert
 * on the addresses the Mailable actually went to.
 */
class BookingNotificationEmailTest extends TestCase
{
    use RefreshDatabase;

    private const SETTING_KEY = 'booking_notification_emails';

    private Doctor $doctor;

    private Branch $branch;

    private int $slotId;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        // "info" email doubles as the fallback booking recipient, and
        // formated_price() reads the currency out of the same row.
        Setting::create([
            'key' => 'info',
            'value' => json_encode([
                'email' => 'info@example.com',
                'currency' => 'BDT',
            ]),
        ]);
        Cache::forget('currency');
        $this->doctor = Doctor::factory()->create([
            'video_consultation_available' => true,
        ]);

        $this->branch = Branch::factory()->create();

        $this->doctor->branchSchedules()->create([
            'branch_id' => $this->branch->id,
            'consultant' => 'Medicine',
            'schedule_days' => 'Sun, Wed',
            'schedule_time' => '10:00 AM - 01:00 PM',
        ]);

        $this->slotId = DoctorConsultationSlot::create([
            'label' => '09:00 AM - 09:30 AM',
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
            'status' => true,
            'sort_order' => 1,
        ])->id;
    }

    /**
     * The next future occurrence of a weekday, as Y-m-d.
     */
    private function nextWeekday(string $threeLetterDay): string
    {
        $today = Carbon::now(config('app.timezone'))->startOfDay();

        for ($offset = 0; $offset < 8; $offset++) {
            $candidate = $today->copy()->addDays($offset);

            if ($candidate->format('D') === $threeLetterDay) {
                return $candidate->toDateString();
            }
        }

        $this->fail("Could not resolve a future {$threeLetterDay}.");
    }

    /**
     * Assert the admin notification reached exactly the given addresses.
     *
     * Recipients are handed to Mail::to(), so they live on the Mailable's
     * "to" property rather than anywhere the Mailable itself exposes.
     */
    private function assertNotified(array $emails): void
    {
        Mail::assertSentTimes(AdminBookingNotification::class, 1);
        Mail::assertSent(AdminBookingNotification::class, $emails);
    }

    private function assertNotNotified(array $emails): void
    {
        foreach ($emails as $email) {
            Mail::assertNotSent(AdminBookingNotification::class, $email);
        }
    }

    private function saveRecipients(array $emails): void
    {
        Setting::create([
            'key' => self::SETTING_KEY,
            'value' => json_encode($emails),
        ]);
    }

    private function storedRecipients(): array
    {
        return json_decode(Setting::where('key', self::SETTING_KEY)->value('value'), true);
    }

    private function bookAppointment(): void
    {
        $this->post(route('book-doctor.submit', $this->doctor->slug), [
            'patient_name' => 'Test Patient',
            'phone' => '01700000000',
            'email' => 'patient@example.com',
            'visit_type' => 'in_hub',
            'branch_id' => $this->branch->id,
            'appointment_date' => $this->nextWeekday('Wed'),
            'doctor_consultation_slot_id' => $this->slotId,
        ])->assertRedirect();
    }

    /**
     * As an admin, id 1 is the hard-coded super-admin that User::can() lets
     * through every permission check.
     */
    private function actingAsSuperAdmin(): User
    {
        return User::factory()->create(['id' => 1]);
    }

    public function test_booking_notifies_every_configured_recipient(): void
    {
        $this->saveRecipients(['reception@example.com', 'duty@example.com', 'front.desk@example.com']);

        $this->bookAppointment();

        $this->assertNotified([
            'reception@example.com',
            'duty@example.com',
            'front.desk@example.com',
        ]);
    }

    /**
     * The general contact email is shared with patient-facing mail, so it must
     * stop receiving booking notifications once a real list is configured.
     */
    public function test_configured_recipients_replace_the_general_contact_email(): void
    {
        $this->saveRecipients(['reception@example.com']);

        $this->bookAppointment();

        $this->assertNotNotified(['info@example.com']);
        $this->assertNotified(['reception@example.com']);
    }

    public function test_a_single_recipient_still_works(): void
    {
        $this->saveRecipients(['solo@example.com']);

        $this->bookAppointment();

        $this->assertNotified(['solo@example.com']);
    }

    /**
     * Backwards compatibility: an install that never opens the new form has no
     * settings row, and must keep notifying the general contact email.
     */
    public function test_it_falls_back_to_the_general_contact_email_when_never_configured(): void
    {
        $this->assertDatabaseMissing('settings', ['key' => self::SETTING_KEY]);

        $this->bookAppointment();

        $this->assertNotified(['info@example.com']);
    }

    /**
     * A saved but empty list is the deliberate opt-out, which is why it is
     * distinct from the missing row above.
     */
    public function test_an_explicitly_empty_list_sends_nothing(): void
    {
        $this->saveRecipients([]);

        $this->bookAppointment();

        $this->assertDatabaseCount('doctor_consultation_bookings', 1);
        Mail::assertNotSent(AdminBookingNotification::class);
    }

    public function test_a_rejected_booking_does_not_notify_anyone(): void
    {
        $this->saveRecipients(['reception@example.com']);

        // A Monday is outside this doctor's "Sun, Wed" schedule.
        $this->post(route('book-doctor.submit', $this->doctor->slug), [
            'patient_name' => 'Test Patient',
            'phone' => '01700000000',
            'email' => 'patient@example.com',
            'visit_type' => 'in_hub',
            'branch_id' => $this->branch->id,
            'appointment_date' => $this->nextWeekday('Mon'),
            'doctor_consultation_slot_id' => $this->slotId,
        ])->assertSessionHasErrors('appointment_date');

        Mail::assertNotSent(AdminBookingNotification::class);
    }

    public function test_an_admin_can_save_multiple_recipients(): void
    {
        $admin = $this->actingAsSuperAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => [
                    'Reception@Example.com',
                    ' duty@example.com ',
                ],
            ])
            ->assertRedirect(route('admin.settings.index'))
            ->assertSessionHas('success');

        // Normalised on write: trimmed, lowercased and de-duplicated.
        $this->assertSame(
            ['reception@example.com', 'duty@example.com'],
            $this->storedRecipients()
        );
    }

    public function test_saving_duplicate_addresses_stores_one_copy(): void
    {
        $admin = $this->actingAsSuperAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => [
                    'reception@example.com',
                    'Reception@Example.com',
                    '  RECEPTION@example.com  ',
                ],
            ])
            ->assertRedirect(route('admin.settings.index'));

        $this->assertSame(['reception@example.com'], $this->storedRecipients());
    }

    /**
     * Clearing every row is how an admin turns the notifications off, so it must
     * save as an empty list rather than fail validation.
     */
    public function test_clearing_all_rows_saves_an_empty_list(): void
    {
        $admin = $this->actingAsSuperAdmin();
        $this->saveRecipients(['reception@example.com']);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => ['', null],
            ])
            ->assertRedirect(route('admin.settings.index'))
            ->assertSessionHasNoErrors();

        $this->assertSame([], $this->storedRecipients());
    }

    /**
     * Saving twice must update in place rather than leaving a second row.
     */
    public function test_saving_twice_updates_the_existing_row(): void
    {
        $admin = $this->actingAsSuperAdmin();
        $this->saveRecipients(['first@example.com']);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => ['second@example.com'],
            ])
            ->assertRedirect(route('admin.settings.index'));

        $this->assertSame(1, Setting::where('key', self::SETTING_KEY)->count());
        $this->assertSame(['second@example.com'], $this->storedRecipients());
    }

    public function test_an_invalid_address_is_rejected(): void
    {
        $admin = $this->actingAsSuperAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => ['good@example.com', 'not-an-email'],
            ])
            ->assertSessionHasErrors('booking_notification_emails.1');

        $this->assertDatabaseMissing('settings', ['key' => self::SETTING_KEY]);
    }

    /**
     * A half-typed address alongside a blank row must still be caught, and the
     * error has to land on the row the admin actually typed.
     */
    public function test_an_invalid_address_is_caught_alongside_a_blank_row(): void
    {
        $admin = $this->actingAsSuperAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => ['', 'not-an-email'],
            ])
            ->assertSessionHasErrors('booking_notification_emails.1');

        $this->assertDatabaseMissing('settings', ['key' => self::SETTING_KEY]);
    }

    public function test_the_recipient_count_is_capped(): void
    {
        $admin = $this->actingAsSuperAdmin();

        $emails = [];
        for ($i = 0; $i < 21; $i++) {
            $emails[] = "recipient{$i}@example.com";
        }

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.booking_notifications_submit'), [
                'booking_notification_emails' => $emails,
            ])
            ->assertSessionHasErrors('booking_notification_emails');

        $this->assertDatabaseMissing('settings', ['key' => self::SETTING_KEY]);
    }

    /**
     * The setting is admin-only: the route sits behind the Admin middleware and
     * the controller's view_setting permission gate.
     */
    public function test_guests_cannot_reach_the_settings_form(): void
    {
        $this->post(route('admin.settings.booking_notifications_submit'), [
            'booking_notification_emails' => ['reception@example.com'],
        ])->assertRedirect(route('admin.login'));

        $this->assertDatabaseMissing('settings', ['key' => self::SETTING_KEY]);
    }

    /**
     * Render just the notification pane out of the real settings view.
     *
     * The full settings page also renders the email, SMS, report, WhatsApp and
     * API-key tabs, each of which reads its own settings row with no null
     * guards. Seeding all of that here would make this test break whenever an
     * unrelated tab gains a key, so the pane is lifted out of the template by
     * its own comment markers and rendered on its own.
     */
    private function renderNotificationPane(array $recipients): string
    {
        $view = file_get_contents(resource_path('views/admin/settings/index.blade.php'));

        // The pane is delimited by the two HTML comments above and below it.
        $start = strpos($view, '<!-- Booking Notifications -->');
        $end = strpos($view, '<!-- \Booking Notifications -->');

        $this->assertNotFalse($start, 'Booking Notifications pane not found.');
        $this->assertNotFalse($end, 'Booking Notifications pane end not found.');

        $pane = substr($view, $start, $end - $start);

        return Blade::render($pane, [
            'booking_notification_emails' => $recipients,
            'errors' => new ViewErrorBag,
        ]);
    }

    public function test_the_notification_pane_renders_the_saved_recipients(): void
    {
        $html = $this->renderNotificationPane(['reception@example.com', 'duty@example.com']);

        $this->assertStringContainsString('Booking Notifications', $html);
        $this->assertStringContainsString('name="booking_notification_emails[]"', $html);
        $this->assertStringContainsString('value="reception@example.com"', $html);
        $this->assertStringContainsString('value="duty@example.com"', $html);
        // One removable row per recipient, plus the hidden JS template.
        $this->assertSame(3, substr_count($html, 'remove-booking-email'));
    }

    /**
     * Never saved means "no rows yet", which is what leaves the booking flow
     * falling back to the general contact email.
     */
    public function test_the_notification_pane_shows_the_fallback_hint_when_empty(): void
    {
        $html = $this->renderNotificationPane([]);

        $this->assertStringContainsString('id="booking-email-empty"', $html);
        $this->assertStringNotContainsString('value="reception@example.com"', $html);
    }

    /**
     * Guards the template against the Blade syntax errors this pane is prone
     * to: rendering it above already compiles it, so this only has to prove the
     * pane is still wired to the route and the repeater controls the JS clones.
     */
    public function test_the_notification_pane_is_wired_to_its_route_and_repeater(): void
    {
        $html = $this->renderNotificationPane(['reception@example.com']);

        $this->assertStringContainsString(route('admin.settings.booking_notifications_submit'), $html);
        $this->assertStringContainsString('id="booking-email-row-template"', $html);
        $this->assertStringContainsString('id="add-booking-email"', $html);
    }
}
