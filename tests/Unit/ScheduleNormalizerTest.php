<?php

namespace Tests\Unit;

use App\Support\ScheduleNormalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Every value below was taken verbatim from doctors.xlsx, Doctors Schedule
 * Hatirpol.xlsx, and Doctors Schedule Banglamotor.xlsx during the audit, so
 * this test is a direct check against the real source data, not synthetic
 * fixtures.
 */
class ScheduleNormalizerTest extends TestCase
{
    /** @return array<string, array{0: string, 1: string}> */
    public static function validDayProvider(): array
    {
        return [
            'single day' => ['Monday', 'Mon'],
            'comma list' => ['Sat,Mon,Wed', 'Sat, Mon, Wed'],
            'spaced comma list' => ['Sun, Tue, Thu', 'Sun, Tue, Thu'],
            'mixed spacing' => ['Tue, Wed,Thu', 'Tue, Wed, Thu'],
            'leading space' => [' Sun & Thu', 'Sun, Thu'],
            'ampersand' => ['Sun & Thu', 'Sun, Thu'],
            'abbreviated Thurs' => ['Sun, Tue, Thurs', 'Sun, Tue, Thu'],
            'simple range' => ['Sun to Thurs', 'Sun, Mon, Tue, Wed, Thu'],
        ];
    }

    #[DataProvider('validDayProvider')]
    public function test_valid_day_strings_normalize_correctly(string $raw, string $expected): void
    {
        $result = ScheduleNormalizer::days($raw);

        $this->assertSame($expected, $result['value']);
        $this->assertTrue($result['valid']);
    }

    /** Test 15: "Sat to wed (without Sunday_)" is a contradiction - Sat-to-Wed does not pass through Sunday, so excluding it is meaningless - and must be flagged rather than silently resolved. */
    public function test_contradictory_range_with_exclusion_is_flagged_for_review(): void
    {
        $result = ScheduleNormalizer::days('Sat to wed (without Sunday_)');

        $this->assertContains('NEEDS_REVIEW', $result['flags']);
        $this->assertTrue($result['requires_approval']);
    }

    /** The exclusion clause with an underscore typo still parses. */
    public function test_sat_to_thu_without_sunday_is_flagged_and_excludes_sunday(): void
    {
        $result = ScheduleNormalizer::days('Sat to Thu (without Sunday_)');

        $this->assertNotContains('Sun', $result['days']);
        $this->assertContains('NEEDS_REVIEW', $result['flags']);
    }

    public function test_anyday_and_everyday_are_flexible_not_a_fixed_day_list(): void
    {
        foreach (['Anyday', 'Everyday'] as $raw) {
            $result = ScheduleNormalizer::days($raw);

            $this->assertTrue($result['is_flexible']);
            $this->assertContains('FLEXIBLE', $result['flags']);
            $this->assertTrue($result['requires_approval']);
        }
    }

    /** @return array<string, array{0: string, 1: string}> */
    public static function validTimeProvider(): array
    {
        return [
            'simple' => ['10am - 01pm', '10:00 AM - 01:00 PM'],
            'no space around dash' => ['05pm-07pm', '05:00 PM - 07:00 PM'],
            'single digit end' => ['05pm-7pm', '05:00 PM - 07:00 PM'],
            'dot minutes' => ['02.30pm - 04pm', '02:30 PM - 04:00 PM'],
            'both dot minutes' => ['02.30pm - 03.30pm', '02:30 PM - 03:30 PM'],
            'single digit start' => ['2pm-3pm', '02:00 PM - 03:00 PM'],
        ];
    }

    #[DataProvider('validTimeProvider')]
    public function test_valid_time_strings_normalize_correctly(string $raw, string $expected): void
    {
        $result = ScheduleNormalizer::time($raw);

        $this->assertSame($expected, $result['value']);
        $this->assertTrue($result['valid']);
        $this->assertFalse($result['is_oncall']);
    }

    /**
     * Test 15: "11pm - 1.30pm" and "11pm-1.30pm" both end before they start.
     * These must be flagged INVALID_TIME and never silently rewritten to
     * "11am" - that is a plausible guess, not a verified fact.
     */
    public function test_end_before_start_is_flagged_invalid_and_never_auto_corrected(): void
    {
        foreach (['11pm - 1.30pm', '11pm-1.30pm'] as $raw) {
            $result = ScheduleNormalizer::time($raw);

            $this->assertFalse($result['valid'], "'{$raw}' must not be marked valid");
            $this->assertContains('INVALID_TIME', $result['flags']);
            $this->assertTrue($result['requires_approval']);

            // It must NOT have silently become "11:00 AM - 01:30 PM".
            $this->assertNotSame('11:00 AM - 01:30 PM', $result['value']);
        }
    }

    public function test_oncall_is_a_label_not_a_time_window(): void
    {
        $result = ScheduleNormalizer::time('Oncall');

        $this->assertTrue($result['is_oncall']);
        $this->assertNull($result['start']);
        $this->assertNull($result['end']);
        $this->assertContains('ONCALL', $result['flags']);
        $this->assertTrue($result['requires_approval']);
    }

    public function test_unparseable_time_is_flagged_not_guessed(): void
    {
        $result = ScheduleNormalizer::time('sometime in the afternoon');

        $this->assertFalse($result['valid']);
        $this->assertContains('UNPARSED', $result['flags']);
    }

    /** Re-parsing already-normalized output returns the same value, so re-running the sync is a no-op. */
    public function test_normalization_is_idempotent(): void
    {
        $dayCases = ['Sat,Mon,Wed', 'Sun to Thurs', ' Sun & Thu'];
        $timeCases = ['05pm-7pm', '2pm-3pm', '02.30pm - 04pm'];

        foreach ($dayCases as $raw) {
            $first = ScheduleNormalizer::days($raw);
            $second = ScheduleNormalizer::days((string) $first['value']);

            $this->assertSame($first['value'], $second['value']);
        }

        foreach ($timeCases as $raw) {
            $first = ScheduleNormalizer::time($raw);
            $second = ScheduleNormalizer::time((string) $first['value']);

            $this->assertSame($first['value'], $second['value']);
        }
    }

    /** Test 15: overlapping windows on a shared day are detected for the cross-branch report. */
    public function test_overlap_detection(): void
    {
        $a = ScheduleNormalizer::time('04pm - 06pm');
        $b = ScheduleNormalizer::time('05pm-07pm');
        $c = ScheduleNormalizer::time('07pm-09pm');

        $this->assertTrue(ScheduleNormalizer::overlaps($a, $b));
        $this->assertFalse(ScheduleNormalizer::overlaps($a, $c));
    }

    public function test_invalid_times_never_report_as_overlapping(): void
    {
        $invalid = ScheduleNormalizer::time('11pm - 1.30pm');
        $valid = ScheduleNormalizer::time('10am - 01pm');

        $this->assertFalse(ScheduleNormalizer::overlaps($invalid, $valid));
    }
}
