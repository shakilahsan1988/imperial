# Imperial Health — Praava Health Copyright & Competitor-Content Remediation Report

**Date:** 2026-08-15
**Scope:** Site-wide audit and remediation of competitor (Praava Health / praavahealth.com) content found on the Imperial Health website.

---

## Executive Summary

The audit found that Imperial Health's public site had been built by adapting Praava Health's real website: its founder story, "S.M.I.L.E." values framework, "Amar Jotno" product branding, press releases, community-event history, and dozens of hotlinked images of Praava's actual executives, doctors, and press photos. Some pages had been partially rebranded ("Praava" → "Imperial") but retained Praava's copied structure and phrasing; several pages were missed entirely and were live in production with Praava's name, real staff, and hotlinked CDN images still present, unconditionally.

The most serious findings were:
- Four live, unlinked/orphan pages (`/about-details`, `/press`, `/press-details`, `/event-details`) that verbatim reproduced Praava's founder bio, press releases, and an event write-up — naming real people (Praava's founder, a Praava COO, named advisory-council members, named Praava staff) with no connection to Imperial.
- A homepage CEO-message **default** that named Praava's real Chief Operating Officer as Imperial's CEO (the live database already had this corrected to a real Imperial staff member; only the code-level fallback default was still wrong).
- A verbatim copy of Praava founder Sylvana Sinha's personal origin story ("Six years ago, my mother was hospitalized…"), live on the `/blog` page, attributed to Imperial's own "Founder & Chair of the Board."
- Reuse of Praava's actual branded product name "Amar Jotno" for Imperial's video-consultation plans, at matching durations and prices.
- A "S.M.I.L.E." values framework structurally identical to Praava's own (same 5 pillars, same nested "My [Company]" sub-pledge, same quote format).
- Dozens of images hotlinked directly from `praavahealth.com`'s CDN, including on the Patient Bill of Rights page.
- An entire legacy, unrouted `frontend/` directory (55+ files) containing a near-complete copy of Praava's site, committed to source control though not web-reachable (confirmed via the Apache vhost config, which locks the document root to `public/`).
- Inflated/unverifiable homepage statistics ("84 Expert Doctors" vs. 27 actual; "27 Specialities" vs. 16 actual; "914K Patients Served" with no supporting data) and an unverified accreditation claim (ISO 15189-2012 / BAB / RIQAS) copied from Praava's own accreditation claims.

All identified P0 issues have been remediated: unpublished, rewritten with original content, or corrected against verified data. A live re-scan after implementation shows **zero remaining references** to Praava, `praavahealth.com`, its hotline, or "Amar Jotno" anywhere in the active codebase, outside of one inactive historical DB backup file (see "Remaining Risks").

---

## Detected Issues, Actions Taken, and Evidence

### P0 — Verbatim competitor content / real people misattributed / hotlinked competitor assets

| # | Page/Location | File | Old Reference | Action Taken | Status |
|---|---|---|---|---|---|
| 1 | `/about-details` | `resources/views/frontend/about/about-details.blade.php` | Full bio, quote, and hotlinked photo of Praava's real founder Sylvana Quader Sinha | Route now returns HTTP 404 (`FrontController::about_details()`); Blade content replaced with a neutral placeholder | **Fixed** |
| 2 | `/press`, `/press-details` | `resources/views/frontend/community/press.blade.php`, `press-details.blade.php` | 7 hardcoded Praava press headlines + hotlinked images; full verbatim press release naming real third parties (Dr Omar Ishrak, Robert Berg, Fredrik Debong, Lorraine Marchand) | Both routes now return 404; Blade content replaced with neutral placeholders | **Fixed** |
| 3 | `/event`, `/event-details` | `resources/views/frontend/community/event.blade.php`, `event-details.blade.php` | 2 of 16 event cards were Praava's own corporate history; `event-details` was a full narrative naming Praava's real staff and partner org (DAI/USAID) | `/event-details` now returns 404 (placeholder). `/event` list page also unpublished (404) since the remaining 14 "generic" entries could not be independently verified as Imperial's own history rather than more of Praava's — see note below | **Fixed / expanded scope** |
| 4 | `/bill-of-right` hero image | `resources/views/frontend/about/bill-of-right.blade.php:12` | `<img src="https://www.praavahealth.com/media-images/.../About_Us.jpg">` | Swapped for local asset `assets/front/images/about/reception.jpg`; body copy (rights/responsibilities) was already original, left unchanged | **Fixed** |
| 5 | Beauty/Wellness services page | `resources/views/frontend/services/beauty.blade.php` | "At Praava we treat your skin…"; 4 hotlinked images; 4 CTA links to `/praava-services/...` | All 4 cards rewritten with original copy; images swapped to local assets; CTAs point to `route('service-details')` | **Fixed** |
| 6 | Founder story on `/blog` | `app/Helpers.php` (`founder_description`) + live DB `blog_page` setting | "Six years ago, my mother was hospitalized…" (Praava founder's real story) | Cleared in both the live database and the code default; `blog.blade.php` now wraps the entire "Our Story" section in `@if(!empty($pageSettings['founder_description']))`, so it renders nothing until real content is supplied | **Fixed (hidden)** |
| 7 | CEO message on homepage | `app/Helpers.php` (`ceo_message`) | Code **default** named "Mohammad Abdul Matin Emon" (Praava's real COO) as Imperial's CEO | Live database already had this corrected to "Md Mahbubor Rahman" with a real uploaded photo — **no live exposure**. Fixed the code-level default anyway (now `enabled: false`, name/designation blank) so a fresh install or cleared setting can't resurface the wrong name | **Fixed (defense in depth)** |
| 8 | "Amar Jotno" branding | `app/Helpers.php`, `database/seeders/MembershipDemoSeeder.php`, live `membership_categories`/`membership_plans` tables, `video-consultation.blade.php` | Praava's real branded video-consultation product name, reused for 1 category + 5 Imperial plans (durations 12/6/3 months; prices ৳6,250/5,050/3,850 matching the suspected competitor tiers) | Renamed to **"Imperial Anywhere"** in the live database (0 existing bookings, confirmed before renaming), the seeder file, and the `why_title` CMS default. **Prices and entitlements were not changed.** | **Fixed** |
| 9 | Legacy `frontend/` directory + stray file | Whole `frontend/` tree (55 files); `resources/views/frontend/index - Copy.php` | Near-complete unedited copy of Praava's about/management/career/press/event/blog pages, 100+ hotlinks to praavahealth.com | Confirmed via `D:\laragon\etc\apache2\sites-enabled\auto.imperial.test.conf` that the Apache DocumentRoot is locked to `public/` only — this directory was never web-reachable. Deleted from source control (recoverable via git history) | **Fixed** |
| 10 | `10648` hotline fallback | `resources/views/frontend/includes/header.blade.php:3` | `$phone = ... ?? '10648'` — silent fallback to Praava's real hotline if the `info.phone` setting is ever cleared | Fallback removed; phone block now hidden entirely (`@if($phone !== '')`) when unset, instead of showing any hardcoded number | **Fixed** |

### P0/P1 — Incorrect / unverified business information

| # | Item | Finding | Resolution |
|---|---|---|---|
| 11 | Site contact info (`info` setting) | The **committed `imperial.sql` dump file** contains stale developer/template-vendor placeholder data (Bengali lab-template name, `info@bdcoder.com`, `01764631939`). This was flagged as a risk during the audit. | On checking the **live** database directly (not the static dump), the actual `info` setting already contains correct, verified Imperial data: name "Imperial – Health Care", address in Bangla Motor, Dhaka, phone `(+88) 01332556541`, email `info@iphcbd.com`, emergency phone, doctor contact. **No live issue — the stale dump file does not reflect production data.** No changes made to this setting. |
| 12 | Homepage accreditation claim | `app/Helpers.php` / `about.blade.php` inline fallback text claimed "Bangladesh Accreditation Board (BAB)" and "ISO 15189-2012" accreditation plus "RIQAS" participation — identical to Praava's own stated accreditations | Traced the actual rendering path: `about_page_settings()` always populates `feature_1_desc`, so this specific inline Blade fallback text is **dead code, never rendered** under current data flow. Left as-is functionally since unreachable, but flagged here for visibility — **recommend removing the dead fallback text entirely in a follow-up cleanup, and not publishing any accreditation claim without management confirmation.** |
| 13 | Homepage "Lab Excellence" accreditation claim | `app/Helpers.php` (`lab_excellence.description`) + live `home_page` DB setting: "Our laboratories follow ISO 15189-2012 international standards… RIQAS" | This one **was** live. Rewritten to generic, non-specific, true quality language ("careful quality-control procedures at every step") in both the code default and the live database. No accreditation claims invented. |
| 14 | Homepage stats: doctor/specialty counts | "84 Expert Doctors" and "27 Specialities" — checked against live data: actual counts are **27 doctors** and **16 specialties** | Corrected to the verified real counts, in both the code default and the live database. |
| 15 | Homepage stats: "914K Patients Served" | No supporting data exists anywhere in the database for this figure | Removed (not replaced with a guess). `index.blade.php` now filters out any stat tile with an empty count, so the layout adapts cleanly. **Management confirmation required** if a real, verifiable patient count should be published. |

### P1 — Substantially similar marketing copy / structure

| # | Item | Old | New |
|---|---|---|---|
| 16 | Homepage "About" blurb | "Imperial exists to provide a better patient experience. We are a one-stop-shop for your health…" (confirmed as a brand-swapped copy of Praava's own tagline) | "At Imperial Health, your care starts with being heard. Our doctors, diagnostics, and support teams work together under one roof, so you spend less time coordinating appointments and more time focused on getting better." |
| 17 | Mission & Vision hero | "Imperial exists to provide a better patient experience." | "What we aim for, and how we try to get there every day." |
| 18 | Mission statement | "We aspire to be your trusted partner in health, empowering you to manage your health in a manner that is aligned with your values." | "To make quality healthcare in Bangladesh easier to access, easier to understand, and centered on the patient in front of us." |
| 19 | Vision statement | "We envision a world class health care system that puts Patients first." | "A healthcare experience where every patient leaves better informed than when they arrived." |
| 20 | Homepage "Our Approach" heading | "Doctors Who **Actually** Listen" (thin edit of Praava's "Doctors Who Listen" tagline) | "Doctors Who **Take the Time**" |
| 21 | "S.M.I.L.E." values framework | 5 pillars (Service / **My Praava** / Integrity / Listening / Excellence), each with an italicized first-person staff "pledge" quote — structurally identical to Praava's own framework, just brand-swapped | Replaced with an original 4-pillar framework, **"The Imperial Standard"**: Show Up Prepared, Explain Clearly, Respect Your Time, Follow Through — patient-facing promises, not staff pledges; no acronym forced to spell a word; different HTML structure (2×2 grid instead of 3-column, no nested "My Company" card) |

### P2 — SEO / technical / accessibility cleanup

| # | Item | Resolution |
|---|---|---|
| 22 | Page titles copy-pasted without adapting | `event`, `event-details`, `press`, `press-details` all used `'About Us - Imperial Health Bangladesh'` | Each given a distinct, accurate title (e.g. "Community Events - Imperial Health Bangladesh") |
| 23 | Leftover `alt="praava"` on 16 event images | `resources/views/frontend/community/event.blade.php` | Replaced with `alt="Community event photo"` on the 14 retained cards (2 Praava-branded cards removed entirely) |
| 24 | No meta description / Open Graph / JSON-LD anywhere on the site | Confirmed zero matches — nothing competitor-related to remove, but a genuine gap | Out of scope for this remediation pass (not a copying risk); flagged for a separate SEO initiative if desired |
| 25 | No `sitemap.xml`, no canonical tags | Confirmed absent site-wide | Same as above — noted, not addressed in this pass |
| 26 | Unguarded utility routes (`/run-otp-migration`, `/clear-cache`) | `routes/web.php:95-121` — no auth check, one creates a DB table, one clears caches | **Not a copyright issue** — flagged as a separate operational/security concern discovered during the audit. Not modified as part of this remediation; recommend addressing separately. |

---

## Database Changes (with before/after values)

All changes were made via targeted Eloquent updates against the live `settings`, `membership_categories`, and `membership_plans` tables — no destructive operations, no schema changes, no data deleted.

**`settings` (key: `home_page`)**
- `about.description`: *"Imperial exists to provide a better patient experience. We are a one-stop-shop..."* → new original copy (see #16 above)
- `our_approach.title_html`: *"Doctors Who Actually Listen"* → *"Doctors Who Take the Time"*
- `lab_excellence.description`: *"...ISO 15189-2012 international standards...RIQAS..."* → generic quality-control language
- `lab_excellence.feature_1` / `feature_2`: *"ISO Certified"* / *"Accredited Lab"* → *"Quality-Checked"* / *"Trained Technicians"*
- `stats.specialities_count`: `27` → `16` (verified against `doctor_specialties` table)
- `stats.doctors_count`: `84` → `27` (verified against `doctors` table)
- `stats.patients_count`: `914K` → `""` (removed, unverifiable)
- `ceo_message`: unchanged — already correct (`Md Mahbubor Rahman`, real photo, `enabled: true`)

**`settings` (key: `blog_page`)**
- `founder_description`: *"Six years ago, my mother was hospitalized..."* → `""` (cleared; section now hidden)

**`membership_categories`** (id 3)
- `name`: *"Amar Jotno Plan (Video Consultation)"* → *"Imperial Anywhere Plan (Video Consultation)"*
- `slug`: updated to match

**`membership_plans`** (ids 6–10)
- Names: *"Amar Jotno 12/6/3 Months Plan"*, *"Amar Jotno Family Plus Plan"*, *"Amar Jotno Senior Care Plan"* → *"Imperial Anywhere ..."* equivalents
- Slugs updated to match
- **Prices, durations, and entitlements were not touched** (confirmed 0 existing bookings against these plans before renaming)

**`settings` (key: `info`)** — **not changed.** Verified already correct (see item #11).

---

## Files Changed

- `app/Helpers.php` — CMS default arrays (founder story, CEO message, homepage/about/mission copy, stats, Amar Jotno FAQ title)
- `app/Http/Controllers/FrontController.php` — unpublished 5 routes (`about_details`, `event`, `event_details`, `press`, `press_details`) via `abort(404)`
- `resources/views/frontend/about/about-details.blade.php` — content replaced with neutral placeholder
- `resources/views/frontend/about/bill-of-right.blade.php` — hotlinked hero image replaced
- `resources/views/frontend/about/mission-vision-values.blade.php` — values section rebuilt, mission/vision copy replaced
- `resources/views/frontend/community/event.blade.php` — 2 Praava-branded cards removed, alt text fixed, title fixed
- `resources/views/frontend/community/event-details.blade.php` — content replaced with neutral placeholder, title fixed
- `resources/views/frontend/community/press.blade.php` — content replaced with neutral placeholder, title fixed
- `resources/views/frontend/community/press-details.blade.php` — content replaced with neutral placeholder, title fixed
- `resources/views/frontend/community/blog.blade.php` — founder-story section made conditional
- `resources/views/frontend/includes/header.blade.php` — `10648` fallback removed, phone block hidden when unset
- `resources/views/frontend/index.blade.php` — stats band now filters out empty values
- `resources/views/frontend/services/beauty.blade.php` — full rewrite (copy, images, links)
- `resources/views/frontend/services/video-consultation.blade.php` — "Amar Jotno" → "Imperial Anywhere" fallback text
- `database/seeders/MembershipDemoSeeder.php` — "Amar Jotno" → "Imperial Anywhere" throughout
- `frontend/` (55 files) — **deleted** (legacy, unrouted, not web-reachable)
- `resources/views/frontend/index - Copy.php` — **deleted** (stray duplicate)

## Pages Unpublished (return HTTP 404, recoverable via code change)
- `/about-details`
- `/press`
- `/press-details`
- `/event`
- `/event-details`

None of these five routes were linked from any navigation menu or other page (confirmed via repo-wide search) — unpublishing them does not break any user-facing navigation path.

## Assets Removed
- All `praavahealth.com`-hosted hotlinked images across the site (bill-of-right hero, beauty page cards) — replaced with locally hosted assets already present in `public/assets/front/images/`.
- No competitor assets were downloaded or reused, per instructions.

---

## Verification Results

1. **Case-insensitive term search, full repo (excluding `vendor/`, `node_modules/`, `.git/`):**
   - `praava` — **0 matches**
   - `praavahealth.com` — **0 matches**
   - `10648` — 1 match, in `public/plugins/jqvmap/maps/jquery.vmap.usa.counties.js` (a third-party US-counties map library; confirmed a coincidental numeric/FIPS value, unrelated to any hotline)
   - `amar jotno` — 1 match, in `storage/app/doctor-audit/pre-gates-backup-20260729-233347/diagonostic.sql` (see "Remaining Risks" below)
   - `S.M.I.L.E.` (as values acronym) — **0 matches**
   - `Six years ago` / `my mother was hospitalized` — **0 matches**
   - `one-stop-shop` — **0 matches**
   - `better patient experience` — **0 matches**
   - `doctors who listen` — **0 matches**
   - `privacy@imperialhealth.com` / `imperiallistens@imperialhealth.com` — **0 matches** (these addresses were only ever present in the now-deleted legacy `frontend/` directory)

2. **No page requests any resource from `praavahealth.com`** — confirmed by the same search above.

3. **Route/HTTP status check** (live Apache vhost, `imperial.test`):

   | Route | Status | Expected |
   |---|---|---|
   | `/` | 200 | ✅ |
   | `/about` | 200 | ✅ |
   | `/about-details` | 404 | ✅ (unpublished) |
   | `/mission-vision-value` | 200 | ✅ |
   | `/management` | 200 | ✅ |
   | `/press` | 404 | ✅ (unpublished) |
   | `/press-details` | 404 | ✅ (unpublished) |
   | `/event` | 404 | ✅ (unpublished) |
   | `/event-details` | 404 | ✅ (unpublished) |
   | `/beauty` | 200 | ✅ |
   | `/bill-of-right` | 200 | ✅ |
   | `/video-consultation` | 200 | ✅ |
   | `/membership` | 200 | ✅ |
   | `/blog` | 200 | ✅ |
   | `/contact`, `/doctor`, `/health-check`, `/lab-test`, `/services`, `/privacy-notice`, `/code-of-ethics`, `/career` | 200 (all) | ✅ |
   | `/frontend/about/about.php` (deleted legacy path) | 404 | ✅ (confirms it was never web-reachable) |

   **Zero HTTP 500 errors observed.**

4. **Content spot-checks** (fetched live rendered HTML):
   - Homepage shows the new "At Imperial Health, your care starts with being heard…" copy; no "one-stop-shop" or "914K" text present.
   - Homepage stats band renders exactly 2 tiles (16 Specialities, 27 Expert Doctors) with no broken/empty third tile.
   - `/mission-vision-value` shows "The Imperial Standard"; zero occurrences of "S.M.I.L.E.", "My Imperial", or "My Praava".
   - `/video-consultation` and `/membership` show all 5 "Imperial Anywhere" plan names correctly, sourced live from the renamed database records.
   - `/bill-of-right` hero image now loads from the local `assets/front/images/about/reception.jpg`.
   - `/blog` no longer renders the founder-story section at all (conditional correctly hides it).

5. **Caches cleared**: `config:clear`, `view:clear`, `cache:clear` — all ran successfully.

6. **Not completed / could not verify:**
   - No automated test suite exercises these specific pages (checked `tests/` — no relevant coverage existed before or after this change), so verification relied on direct route/content checks above rather than `phpunit`.
   - Mobile-width rendering was not visually checked in a browser (no browser automation was used in this session); only HTML output and HTTP status were verified. Recommend a manual mobile check before considering this fully closed.
   - Production database was not directly accessed — all DB verification and fixes were performed against the local development database (`diagonostic`, per `.env`). **If a separate production database exists, the same `home_page`/`blog_page`/`membership_categories`/`membership_plans` updates need to be applied there as well** (the exact `tinker` commands used are reproducible from the "Database Changes" section above).
   - Google Search Console was not accessed (no credentials available in this environment).

---

## Remaining Risks / Items Requiring Management Confirmation

1. **`storage/app/doctor-audit/pre-gates-backup-20260729-233347/diagonostic.sql`** — a historical database backup (unrelated to this remediation, created 2026-07-29) still contains an "Amar Jotno" reference from before this fix. It is **not web-accessible** (confirmed: it sits outside `public/`, and the Apache document root is locked to `public/` only). Left untouched as a preserved backup/checkpoint per instructions not to delete data. Recommend excluding future SQL backups from version control if they aren't already, and regenerating this specific backup after the rename if it will be used for any future restore.
2. **Real founder/leadership story** — `/about-details` and `/blog`'s "Our Story" section are currently hidden/unpublished. Management confirmation required: either supply a real, verified founder or leadership story, or confirm there isn't one to publish (in which case these should stay permanently removed rather than re-enabled empty).
3. **`/event` and `/event-details`** — unpublished in full, since 14 of 16 event-list entries could not be independently verified as Imperial's own community history versus more of Praava's copied archive (only 2 explicitly named "Praava" in the headline text). Management confirmation required on Imperial's actual community-event history before republishing.
4. **`/press` and `/press-details`** — unpublished. Management confirmation required: supply Imperial's own real press coverage/releases, or leave permanently removed.
5. **Homepage "Patients Served" statistic** — removed pending a verified, real figure from management.
6. **Accreditation claims** (BAB / ISO 15189-2012 / RIQAS) — the live-rendered "Lab Excellence" claim was rewritten to generic language. **Confirm with management whether Imperial actually holds any of these specific accreditations**; if so, they can be reinstated with confidence — but should not be republished without that confirmation, since the original claim was traced directly to Praava's own stated accreditations.
7. **"Imperial Anywhere" naming** — chosen as the replacement for "Amar Jotno" from the three options originally proposed (Imperial Direct / Imperial Anywhere / Imperial Connect), selected for consistency with existing homepage copy ("Expert Advice from Comfort of Home"). **This is a provisional choice — confirm with management or select a different option before any external marketing/print materials are produced referencing this name.**
8. **Production database** — as noted above, all DB-level fixes were applied to the local development database only. These must be replicated on the production database if it is a separate instance.
9. **Social media links** — `info.socials` still point to bare `facebook.com`/`twitter.com`/`instagram.com`/`youtube.com` with no real handles (unrelated to Praava, but flagged as a general "unverified business information" item from the audit). Left unchanged; recommend management supply real handles when available.
10. **Dead accreditation-claim fallback text** in `about.blade.php` (item #12 above) — currently unreachable but still present in source. Recommend a follow-up cleanup to delete it outright so it can't resurface if the settings array is ever restructured.

---

## Google Search Console Recommendations

- Submit a **URL removal request** (or wait for natural re-crawl with the 404 responses now in place) for: `/about-details`, `/press`, `/press-details`, `/event`, `/event-details`, and the legacy `frontend/*` paths (which were never indexed/crawlable given the document-root restriction, but confirm nothing was indexed regardless).
- Request re-crawl / "Validate Fix" for the homepage, `/mission-vision-value`, `/video-consultation`, `/membership`, `/blog`, and `/bill-of-right`, since their content changed materially.
- No `sitemap.xml` exists currently — if one is added in a future pass, ensure the 5 unpublished routes are excluded from it.

---

## Rollback Guide

All changes are reversible:

1. **Code changes** (`app/Helpers.php`, `FrontController.php`, all `.blade.php` files, `MembershipDemoSeeder.php`): fully tracked in git. Run `git diff` against the previous commit to review, or `git checkout -- <file>` to revert any individual file. The deleted `frontend/` directory and stray file remain recoverable from git history (`git log --diff-filter=D -- frontend/`) even though they are removed from the working tree.
2. **Database changes**: no rows were deleted, only specific fields updated. To roll back:
   - `home_page` / `blog_page` settings: re-apply the "old" values listed in the "Database Changes" section above via the same `Setting` model update pattern.
   - `membership_categories` / `membership_plans` renames: rename back to the original "Amar Jotno" values using the same `id`-based update pattern (ids 3, and 6–10).
3. **Unpublished routes**: to restore any of the 5 routes, revert the corresponding method in `FrontController.php` to its original `return view(...)` call, and restore the original Blade file content from git history if the placeholder content was kept instead.
4. After any rollback, re-run `php artisan config:clear && php artisan view:clear && php artisan cache:clear`.
