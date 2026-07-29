<?php

/*
|--------------------------------------------------------------------------
| Doctor Sync & Image Configuration
|--------------------------------------------------------------------------
|
| Central configuration for the doctor audit/synchronisation tooling and for
| doctor image handling. Every value here is reviewable without touching code,
| which is deliberate: the mappings below decide how spreadsheet rows are
| matched to database records, and they must be auditable by a human.
|
| See docs/doctor-data-sync.md for the operating procedure.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Shared avatar assets
    |--------------------------------------------------------------------------
    |
    | Paths are public-relative. These are SHARED IMMUTABLE ASSETS: they live
    | outside public/uploads/ precisely so that no doctor upload, replace, or
    | delete operation can ever reach them.
    |
    | The 'unknown' avatar is what every doctor without a personal photo will
    | actually display until the gender column exists (Gate B) and has been
    | filled in, because doctors.gender does not exist yet.
    |
    */
    'avatars' => [
        'male' => 'img/avatars/male-doctor-avatar.jpg',
        'female' => 'img/avatars/female-doctor-avatar.jpg',

        // TEMPORARY (pending decision Q1). This currently points at the image
        // that the public pages already used as their doctor fallback, so the
        // visible behaviour is unchanged. Replace with a dedicated neutral
        // doctor avatar once one has been supplied and approved.
        'unknown' => 'assets/front/images/doctor/2.jpg',

        // Last-resort asset used only if a configured avatar file is missing
        // from disk. Prevents a broken <img> if deployment forgets an asset.
        'fallback' => 'img/no-image.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Doctor image uploads
    |--------------------------------------------------------------------------
    |
    | Uploads are stored per-doctor: uploads/doctors/{doctor_id}/{uuid}.{ext}
    | The doctor id segment is what makes cross-doctor collisions impossible
    | and what makes ownership provable at delete time.
    |
    */
    'uploads' => [
        'base_directory' => 'uploads/doctors',
        'max_kilobytes' => 5120,
        'min_width' => 200,
        'min_height' => 200,
        'max_width' => 4000,
        'max_height' => 4000,

        // Extension => canonical mime type. The stored extension is derived
        // from the validated mime type, never from client-supplied input.
        'allowed_types' => [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source workbooks and images
    |--------------------------------------------------------------------------
    |
    | 'default_directory' may be overridden with the --source option.
    |
    */
    'sources' => [
        'default_directory' => env('DOCTOR_SOURCE_DIR'),
        'profile_workbook' => 'doctors.xlsx',
        'schedule_workbook_glob' => 'Doctors Schedule*.xlsx',
        'image_directory' => 'images',

        // doctors.xlsx: header on row 1, data in columns C..G.
        // Columns A and B hold leftover scratch text and are ignored.
        'profile' => [
            'first_data_row' => 2,
            'columns' => [
                'name' => 'C',
                'qualification' => 'D',
                'designation' => 'E',
                'address' => 'F',
                'bio' => 'G',
            ],
        ],

        // Schedule workbooks: rows 1-3 are a merged title block, row 4 is the
        // header, data starts at row 5. Cell A3 carries the branch name.
        'schedule' => [
            'branch_cell' => 'A3',
            'first_data_row' => 5,
            'columns' => [
                'serial' => 'A',
                'name' => 'B',
                'consultant' => 'C',
                'days' => 'D',
                'time' => 'E',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Branch resolution
    |--------------------------------------------------------------------------
    |
    | Branches are ALWAYS resolved by normalised name against the branches
    | table, never by hard-coded id, because ids differ between environments.
    | An unmapped branch string is a hard error - never guess a branch.
    |
    | Keys are normalised branch tokens; values are the canonical token that
    | must match a branch row after the same normalisation is applied to it.
    |
    */
    'branch_aliases' => [
        'hatirpool' => 'hatirpool',
        'hatirpol' => 'hatirpool',
        'hatirpul' => 'hatirpool',
        'hatir pul' => 'hatirpool',
        'hatir pool' => 'hatirpool',
        'hatirpool branch' => 'hatirpool',

        'banglamotor' => 'banglamotor',
        'bangla motor' => 'banglamotor',
        'banglamoter' => 'banglamotor',
        'banglamotor branch' => 'banglamotor',
    ],

    // Removed from branch names before normalisation, so that
    // "Imperial Private Health Care (BD) Ltd. (Hatirpool Branch)" reduces to
    // the token "hatirpool".
    'branch_noise' => [
        'imperial private health care (bd) ltd.',
        'imperial private healthcare (bd) ltd.',
        'imperial private health care bd limited',
        'branch',
    ],

    /*
    |--------------------------------------------------------------------------
    | Doctor name aliases
    |--------------------------------------------------------------------------
    |
    | The schedule workbooks spell several doctors differently from
    | doctors.xlsx. These are curated, reviewed equivalences - NOT fuzzy
    | matches. Keys and values are both post-normalisation (lowercased, titles
    | stripped, punctuation collapsed).
    |
    | Adding an entry here asserts "these two strings are the same human".
    | Never add one without confirming it against the source documents.
    |
    */
    'doctor_aliases' => [
        'shahid hossen' => 'md shahid hossain',
        'shahid hossain' => 'md shahid hossain',
        'sawda tabassum' => 'khwaja sawda tabassum',
        'mahmudul hakim' => 'khondker mahmudul hakim',
        'mahfuzur rahman' => 'md mahfuzur rahman',
        'khaled mahmood arif' => 'khaled mahmud arif',
        'golam foysal sarkar' => 'golam faysal sarker',
        'shahid md nokib' => 'shahid md nokib',
    ],

    /*
    |--------------------------------------------------------------------------
    | Specialty / department mapping
    |--------------------------------------------------------------------------
    |
    | EXACT normalised lookup only. Substring matching is deliberately NOT
    | used: str_contains('dentist', 'ent') is exactly how the oral surgeon was
    | filed under ENT, and 'medicine' matching before 'cardio' is how the
    | cardiologist landed in the Medicine department.
    |
    | A consultant string that is not an exact key here produces NO write. The
    | row is reported as UNMAPPED_SPECIALTY for manual review.
    |
    */
    'specialties' => [
        'general surgeon' => ['specialty' => 'General Surgery', 'department' => 'Surgery'],
        'medicine' => ['specialty' => 'Medicine', 'department' => 'Medicine'],
        'general physician' => ['specialty' => 'General Medicine', 'department' => 'General Medicine'],
        'psychiatrist' => ['specialty' => 'Psychiatry', 'department' => 'Psychiatry'],
        'dermatologist' => ['specialty' => 'Dermatology', 'department' => 'Dermatology'],
        'ent' => ['specialty' => 'ENT', 'department' => 'ENT'],
        'nephrology' => ['specialty' => 'Nephrology', 'department' => 'Nephrology'],
        'ophthalmology' => ['specialty' => 'Ophthalmology', 'department' => 'Ophthalmology'],
        'gynaecology' => ['specialty' => 'Gynaecology', 'department' => 'Gynaecology'],
        'pulmonology' => ['specialty' => 'Pulmonology', 'department' => 'Pulmonology'],
        'pediatrician' => ['specialty' => 'Pediatrics', 'department' => 'Pediatrics'],
        'orthopedics' => ['specialty' => 'Orthopedics', 'department' => 'Orthopedics'],
        'cardiologist' => ['specialty' => 'Cardiology', 'department' => 'Cardiology'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Specialty values requiring a human decision (Q3)
    |--------------------------------------------------------------------------
    |
    | These consultant strings appear in the workbooks but their correct target
    | is genuinely undecided. They are reported, never written.
    |
    */
    'specialties_requiring_review' => [
        'dentist' => 'Q3 unresolved: the Banglamotor consultant column says "Dentist" while the doctors.xlsx designation says "Consultant - Oral & Maxillofacial Surgery". Neither "Dentistry" nor "Oral & Maxillofacial Surgery" exists in doctor_specialties. Currently mis-filed as ENT by the old substring bug.',
        'cancer' => 'Q3 unresolved: "Cancer" is a job label, not a clinical specialty. The old sync created doctor_specialties/doctor_departments rows named "Cancer" from it.',
        'psychology' => 'Q3 unresolved: derived from the consultant label "Psychology"; the designation reads "Counselor" and the qualification reads "MSc Clinical Psychology", so "Clinical Psychology" may be intended.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Known fabricated values
    |--------------------------------------------------------------------------
    |
    | Generated by the deprecated DoctorDataSyncService, not real contact data.
    | These are (a) never usable as a match key, and (b) eligible to be set to
    | NULL by the audited correction command in Gate C.
    |
    */
    'fabricated' => [
        'emails' => [
            'doctor@iphcbd.com',
        ],
        'phones' => [
            '01332556541',
            '01335100543',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Placeholder detection
    |--------------------------------------------------------------------------
    |
    | Values matching this pattern are NEVER auto-written over. Telling a real
    | placeholder from a real value is a judgement call, so these are reported
    | as SUSPECTED_PLACEHOLDER instead.
    |
    */
    'placeholder_pattern' => '/^(n\/?a|none|null|nil|-{1,3}|tbd|test|x{2,}|\.)$/i',

    /*
    |--------------------------------------------------------------------------
    | Booking protection
    |--------------------------------------------------------------------------
    |
    | Statuses that do NOT block a schedule change. Verified against
    | Admin/DoctorConsultationBookingsController: 'required|in:pending,
    | confirmed,completed,cancelled'. Anything not listed here blocks.
    |
    */
    'bookings' => [
        'non_blocking_statuses' => ['cancelled', 'completed'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit artifacts
    |--------------------------------------------------------------------------
    */
    'audit' => [
        'output_directory' => 'doctor-audit',
    ],
];
