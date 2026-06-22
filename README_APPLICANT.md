# Applicant User Flow

Overview
- This document describes the primary flows for applicants (job seekers) in the project.

landing page hahha xD

Sign up / Authentication
- Routes: `register`, `login`, `logout`
- Controllers: `AuthController` (showRegister, register, showLogin, login, logout)

Profile & Resume
- View: `profile.show` (`ProfileController@show`)
- Edit / Upload resume: `profile.edit` / `profile.update` (`ProfileController@edit` / `update`)
- Uploaded resume is saved to the `public` disk and the session stores quick links for demo purposes.

Browse & Apply
- Public jobs: `jobs.public`
- Applicant job feed: `jobs.applicant` (views/jobs/applicant.blade.php)
- Job detail: `jobs.show` (`JobController@show`)
- Apply: `job/apply/{id}` (`ApplicationController@store`) — submits an application and redirects to `applications.index`.

Applicant Application Views
- `resources/views/jobs/applicant.blade.php` — applicant-facing job feed.
- `resources/views/jobs/show.blade.php` — job detail + apply action.
- `resources/views/applications/applications.blade.php` — applicant's applications list.
- `resources/views/applications/applicant-detail.blade.php` — detailed view an employer sees for an applicant (shared view used in review flow).

Notes
- Current implementation uses demo data for jobs and applicants; persistence (DB-backed jobs/applications) should be added for production.
- Resume downloads are currently streamed from session/demo data. To persist, add a `resume_path` to the user/applicant model and serve files from storage.
