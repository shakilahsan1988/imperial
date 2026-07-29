<?php

namespace App\Support;

/**
 * Parses the free-text schedule strings used by the doctor schedule workbooks.
 *
 * IMPORTANT - what this class is and is not:
 *
 *   It normalises DISPLAY TEXT only. "On Call", "Anyday" and "Everyday" are
 *   descriptive labels, not availability. Bookable availability in this
 *   application comes from the fixed global doctor_consultation_slots table
 *   and is entirely independent of anything parsed here. Nothing this class
 *   returns should ever be used to generate a bookable slot.
 *
 * Every result carries `flags` and `requires_approval`. Any value that needed a
 * judgement call to interpret is flagged and must not be written without a
 * human confirming it - the source data contains a schedule that ends before it
 * starts and a day range that excludes a day it spans.
 */
final class ScheduleNormalizer
{
    /**
     * Canonical week order used for output. Saturday first, matching how the
     * clinic writes its own schedules.
     */
    public const WEEK = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

    /**
     * Accepted spellings for each canonical day.
     */
    private const DAY_TOKENS = [
        'Sat' => ['sat', 'satur', 'saturday'],
        'Sun' => ['sun', 'sunday'],
        'Mon' => ['mon', 'monday'],
        'Tue' => ['tue', 'tues', 'tuesday'],
        'Wed' => ['wed', 'weds', 'wednesday'],
        'Thu' => ['thu', 'thur', 'thurs', 'thursday'],
        'Fri' => ['fri', 'friday'],
    ];

    /**
     * Normalise a "Day" cell.
     *
     * @return array{
     *     original: ?string,
     *     value: ?string,
     *     days: array<int, string>,
     *     is_flexible: bool,
     *     valid: bool,
     *     flags: array<int, string>,
     *     requires_approval: bool
     * }
     */
    public static function days(?string $raw): array
    {
        $original = $raw;
        $flags = [];

        $working = self::collapse($raw);

        if ($working === '') {
            return self::dayResult($original, [], false, false, ['EMPTY']);
        }

        $working = strtolower($working);

        // The workbook writes "(without Sunday_)" with a stray underscore.
        $working = str_replace('_', ' ', $working);

        // Pull out an exclusion clause such as "(without Sunday)".
        $excluded = [];
        if (preg_match('/\((?:without|except|excluding|no)\s+([^)]*)\)/i', $working, $m) === 1) {
            $excluded = self::tokensToDays($m[1]);
            $working = trim(str_replace($m[0], '', $working));
        }

        // "Anyday" / "Everyday" describe flexibility, not a weekday list.
        if (preg_match('/^(any\s?day|every\s?day|all\s?days?|daily|any\s?time)$/i', trim($working)) === 1) {
            $days = self::subtract(self::WEEK, $excluded);

            return self::dayResult($original, $days, true, true, ['FLEXIBLE']);
        }

        $days = [];
        $sawRange = false;

        foreach (preg_split('/\s*(?:,|&|\/|\+|\band\b)\s*/i', $working) as $part) {
            $part = trim((string) $part);

            if ($part === '') {
                continue;
            }

            // "Sat to Thu", "Sat - Thu"
            if (preg_match('/^(.+?)\s*(?:to|-|–|—|until|till)\s*(.+)$/i', $part, $m) === 1) {
                $from = self::toDay($m[1]);
                $to = self::toDay($m[2]);

                if ($from !== null && $to !== null) {
                    $sawRange = true;
                    $days = array_merge($days, self::expandRange($from, $to));

                    continue;
                }
            }

            $day = self::toDay($part);

            if ($day !== null) {
                $days[] = $day;

                continue;
            }

            $flags[] = 'UNPARSED_DAY_TOKEN';
        }

        // A range combined with an exclusion is an unusual construction and the
        // source data uses it inconsistently, so never apply it unreviewed.
        if ($sawRange && $excluded !== []) {
            $flags[] = 'NEEDS_REVIEW';
        }

        $days = self::subtract($days, $excluded);

        if ($days === []) {
            $flags[] = 'UNPARSED';

            return self::dayResult($original, [], false, false, $flags);
        }

        return self::dayResult($original, $days, false, true, $flags);
    }

    /**
     * Normalise a "Time" cell into "hh:mm AM - hh:mm PM".
     *
     * @return array{
     *     original: ?string,
     *     value: ?string,
     *     start: ?string,
     *     end: ?string,
     *     is_oncall: bool,
     *     valid: bool,
     *     flags: array<int, string>,
     *     requires_approval: bool
     * }
     */
    public static function time(?string $raw): array
    {
        $original = $raw;
        $working = self::collapse($raw);

        if ($working === '') {
            return self::timeResult($original, null, null, null, false, false, ['EMPTY']);
        }

        // "Oncall" is a label, not a time window, and carries no availability.
        if (preg_match('/^on[\s-]?call$/i', $working) === 1) {
            return self::timeResult($original, 'On Call', null, null, true, true, ['ONCALL']);
        }

        // Two clock tokens: "10am - 01pm", "02.30pm-04pm", "2pm to 3pm".
        $pattern = '/^\s*(\d{1,2})(?:[.:](\d{1,2}))?\s*(am|pm)?\s*(?:-|–|—|to|till|until)\s*(\d{1,2})(?:[.:](\d{1,2}))?\s*(am|pm)?\s*$/i';

        if (preg_match($pattern, $working, $m) !== 1) {
            return self::timeResult($original, null, null, null, false, false, ['UNPARSED']);
        }

        $endMeridiem = strtolower((string) ($m[6] ?? ''));
        $startMeridiem = strtolower((string) ($m[3] ?? ''));

        // "10 - 01pm" inherits the meridiem from the end of the range.
        if ($startMeridiem === '' && $endMeridiem !== '') {
            $startMeridiem = $endMeridiem;
        }

        if ($startMeridiem === '' || $endMeridiem === '') {
            return self::timeResult($original, null, null, null, false, false, ['UNPARSED']);
        }

        $start = self::toMinutes((int) $m[1], (int) ($m[2] ?? 0), $startMeridiem);
        $end = self::toMinutes((int) $m[4], (int) ($m[5] ?? 0), $endMeridiem);

        if ($start === null || $end === null) {
            return self::timeResult($original, null, null, null, false, false, ['UNPARSED']);
        }

        $startLabel = self::formatMinutes($start);
        $endLabel = self::formatMinutes($end);

        // An end at or before the start is either an overnight shift or - far
        // more likely in this data - a typo. Either way it is never rewritten
        // automatically.
        if ($end <= $start) {
            return self::timeResult(
                $original,
                $startLabel.' - '.$endLabel,
                $startLabel,
                $endLabel,
                false,
                false,
                ['INVALID_TIME']
            );
        }

        return self::timeResult(
            $original,
            $startLabel.' - '.$endLabel,
            $startLabel,
            $endLabel,
            false,
            true,
            []
        );
    }

    /**
     * Whether two time windows on the same day overlap.
     *
     * Used for reporting cross-branch conflicts, never for blocking a booking.
     */
    public static function overlaps(array $a, array $b): bool
    {
        if (! ($a['valid'] ?? false) || ! ($b['valid'] ?? false)) {
            return false;
        }

        $aStart = self::labelToMinutes($a['start'] ?? null);
        $aEnd = self::labelToMinutes($a['end'] ?? null);
        $bStart = self::labelToMinutes($b['start'] ?? null);
        $bEnd = self::labelToMinutes($b['end'] ?? null);

        if ($aStart === null || $aEnd === null || $bStart === null || $bEnd === null) {
            return false;
        }

        return $aStart < $bEnd && $bStart < $aEnd;
    }

    /**
     * Trim, collapse whitespace, and strip invisible characters.
     */
    private static function collapse(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        // Zero-width and non-breaking space characters routinely survive a
        // copy-paste into Excel and would otherwise defeat every comparison.
        $value = str_replace(["\u{200B}", "\u{200C}", "\u{200D}", "\u{FEFF}", "\u{00A0}"], ' ', $value);
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';

        return trim($value);
    }

    /**
     * Resolve a single token to a canonical day, or null.
     */
    private static function toDay(string $token): ?string
    {
        $token = strtolower(trim($token, " \t\n\r\0\x0B.,;:-"));

        if ($token === '') {
            return null;
        }

        foreach (self::DAY_TOKENS as $canonical => $spellings) {
            if (in_array($token, $spellings, true)) {
                return $canonical;
            }
        }

        return null;
    }

    /**
     * Resolve a free-text fragment to every day it mentions.
     *
     * @return array<int, string>
     */
    private static function tokensToDays(string $fragment): array
    {
        $days = [];

        foreach (preg_split('/\s*(?:,|&|\/|\+|\band\b|\s)\s*/i', strtolower($fragment)) as $token) {
            $day = self::toDay((string) $token);

            if ($day !== null) {
                $days[] = $day;
            }
        }

        return $days;
    }

    /**
     * Inclusive weekday range over the Saturday-first week order.
     *
     * @return array<int, string>
     */
    private static function expandRange(string $from, string $to): array
    {
        $start = array_search($from, self::WEEK, true);
        $end = array_search($to, self::WEEK, true);

        if ($start === false || $end === false) {
            return [];
        }

        $days = [];
        $index = $start;

        // Wraps around the end of the week, so "Thu to Sun" behaves sensibly.
        while (true) {
            $days[] = self::WEEK[$index];

            if ($index === $end) {
                break;
            }

            $index = ($index + 1) % count(self::WEEK);
        }

        return $days;
    }

    /**
     * @param  array<int, string>  $days
     * @param  array<int, string>  $excluded
     * @return array<int, string>
     */
    private static function subtract(array $days, array $excluded): array
    {
        $days = array_diff($days, $excluded);

        return self::orderDays($days);
    }

    /**
     * De-duplicate and sort into canonical week order.
     *
     * Deterministic ordering is what makes re-running the sync a no-op.
     *
     * @param  array<int, string>  $days
     * @return array<int, string>
     */
    private static function orderDays(array $days): array
    {
        $unique = array_values(array_unique($days));

        usort($unique, static fn ($a, $b) => array_search($a, self::WEEK, true) <=> array_search($b, self::WEEK, true));

        return $unique;
    }

    /**
     * Convert a 12-hour clock reading to minutes past midnight.
     */
    private static function toMinutes(int $hour, int $minute, string $meridiem): ?int
    {
        if ($hour < 1 || $hour > 12 || $minute < 0 || $minute > 59) {
            return null;
        }

        $hour %= 12;

        if ($meridiem === 'pm') {
            $hour += 12;
        }

        return ($hour * 60) + $minute;
    }

    /**
     * Render minutes past midnight as "hh:mm AM".
     */
    private static function formatMinutes(int $minutes): string
    {
        $hour24 = intdiv($minutes, 60);
        $minute = $minutes % 60;
        $meridiem = $hour24 >= 12 ? 'PM' : 'AM';
        $hour12 = $hour24 % 12;
        $hour12 = $hour12 === 0 ? 12 : $hour12;

        return sprintf('%02d:%02d %s', $hour12, $minute, $meridiem);
    }

    /**
     * Inverse of formatMinutes(), for overlap comparisons.
     */
    private static function labelToMinutes(?string $label): ?int
    {
        if ($label === null || preg_match('/^(\d{2}):(\d{2}) (AM|PM)$/', $label, $m) !== 1) {
            return null;
        }

        return self::toMinutes((int) $m[1], (int) $m[2], strtolower($m[3]));
    }

    /**
     * @param  array<int, string>  $days
     * @param  array<int, string>  $flags
     */
    private static function dayResult(?string $original, array $days, bool $isFlexible, bool $valid, array $flags): array
    {
        $flags = array_values(array_unique($flags));

        return [
            'original' => $original,
            'value' => $days === [] ? null : implode(', ', $days),
            'days' => $days,
            'is_flexible' => $isFlexible,
            'valid' => $valid,
            'flags' => $flags,
            'requires_approval' => $flags !== [],
        ];
    }

    /**
     * @param  array<int, string>  $flags
     */
    private static function timeResult(
        ?string $original,
        ?string $value,
        ?string $start,
        ?string $end,
        bool $isOnCall,
        bool $valid,
        array $flags
    ): array {
        $flags = array_values(array_unique($flags));

        return [
            'original' => $original,
            'value' => $value,
            'start' => $start,
            'end' => $end,
            'is_oncall' => $isOnCall,
            'valid' => $valid,
            'flags' => $flags,
            'requires_approval' => $flags !== [],
        ];
    }
}
