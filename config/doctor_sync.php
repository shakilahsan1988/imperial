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
    | Shared doctor contact details
    |--------------------------------------------------------------------------
    |
    | Doctor profiles intentionally use the central appointment desk's contact
    | details. These values are valid shared data, not fabricated placeholders.
    |
    */
    'shared_contacts' => [
        'email' => 'doctor@iphcbd.com',
        'phone' => '+8801332556541',
    ],

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
        // The real avatar files provided by the operator, copied byte-for-byte
        // into public/img/avatars/ (outside public/uploads/, so no upload,
        // replace, or delete path can ever reach them).
        'male' => 'img/avatars/male-doctor-avatar.jpg',
        'female' => 'img/avatars/female-doctor-avatar.jpg',

        // Only two avatar files were supplied (male, female). This is the
        // fallback for a doctor whose gender is not yet set - not expected to
        // be hit today, since every current doctor has a gender value, but
        // kept as a safe default for any doctor added before gender is filled
        // in. Deliberately reuses the pre-existing public doctor-card
        // placeholder rather than inventing an unsupplied third asset.
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
    | Gender assignments
    |--------------------------------------------------------------------------
    |
    | A curated, human-reviewed lookup of canonical name -> gender - NOT an
    | algorithm run against every name. The operator explicitly authorised
    | determining gender from these specific names (reversing the project's
    | earlier "never infer from a name" default) and reviewed this exact list,
    | including the one lower-confidence entry (Dr. Junia jubaiba) before it
    | was approved. Keys are canonicalName() output - lowercase, honorifics
    | stripped, punctuation flattened, aliases applied.
    |
    | Extending this list follows the same rule as doctor_aliases above: only
    | add an entry you can defend, and prefer leaving a name unmapped (which
    | the audit reports as NEEDS_GENDER_REVIEW) over guessing.
    |
    */
    'gender_map' => [
        'md shahid hossain' => 'male',
        'akil al islam' => 'male',
        'murad mehedi' => 'male',
        'marufa shahrin' => 'female',
        'khwaja sawda tabassum' => 'female',
        'shahid md nokib' => 'male',
        'rudra pratap' => 'male',
        'sharmin jahan' => 'female',
        'samantha meherin' => 'female',
        'khondker mahmudul hakim' => 'male',
        'saymon sahariar' => 'male',
        'md mahfuzur rahman' => 'male',
        'anis ahmed biswas' => 'male',
        'jamil siddiqui bhuiyan' => 'male',
        'mohammad khaled bin ismaeel' => 'male',
        'khaled mahmud arif' => 'male',
        'mohuwa parvin' => 'female',
        'tanjida beente' => 'female',
        'shoaib hossain' => 'male',
        'jakiya akter' => 'female',
        'saidul hoque tipu' => 'male',
        'junia jubaiba' => 'female', // lower confidence; explicitly reviewed and confirmed by the operator
        'tania sharmin' => 'female',
        'golam faysal sarker' => 'male',
        'pavel chowdhuray' => 'male',
        'karim hossain' => 'male',
        'syeda jannatul ferdous' => 'female',
    ],

    /*
    |--------------------------------------------------------------------------
    | Manual schedule corrections
    |--------------------------------------------------------------------------
    |
    | Explicitly approved, one-off corrections to specific schedule rows that
    | the generic normalizer correctly refuses to guess at (e.g. a time window
    | that ends before it starts). Keyed "canonicalDoctorName:branchToken".
    | Applying one of these is logged distinctly from the generic
    | normalization pass in the sync report.
    |
    */
    'manual_schedule_corrections' => [
        // Both read "11pm - 1.30pm" in the source workbook, which ends before
        // it starts. Confirmed by the operator as a transcription error for
        // "11am".
        'junia jubaiba:hatirpool' => ['time' => '11:00 AM - 01:30 PM'],
        'golam faysal sarker:hatirpool' => ['time' => '11:00 AM - 01:30 PM'],
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
        'emails' => [],
        'phones' => [],
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
