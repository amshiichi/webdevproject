# Employer User Flow

Overview
- This document covers the employer experience: posting jobs, tracking applicants, and managing posting status.


Landing Page

Dashboard & Job Hub
- Employer home: `employer.home` (view route defined in `routes/web.php`).
- Job hub: `job` (named route `jobs.hub`) — shows "Post a Job" and lists employer jobs. Implemented in `JobController@hub`.

Create / Edit Job Postings
- Create: `job/create` (`JobController@create` / `jobs.form` view)
- Store: `job/create` POST (`JobController@store`)
- Edit: `job/edit/{id}` (`JobController@edit` renders `jobs.form` with existing job data)
- Update: `job/edit/{id}` POST (`JobController@update`)

Applicant Tracking & Review
- Applications index (role-aware): `applications` (`ApplicationController@index`) — employers are shown the employer dashboard.
- Review applicants for a job: `applications/review/{id}` (`ApplicationController@review`) — renders employer review view.
- Applicant detail: `applications/review/{jobId}/applicant/{applicantId}` (`ApplicationController@applicant`)
- Resume download: `applications/review/{jobId}/applicant/{applicantId}/resume` (`ApplicationController@resume`)

Employer Views (repository locations)
- `resources/views/employer/home.blade.php` — employer home page
- `resources/views/employer/hub.blade.php` — job hub (moved from jobs/ to employer/)
- `resources/views/employer/dashboard.blade.php` — employer dashboard (moved)
- `resources/views/employer/review.blade.php` — applicant review (moved from applications/)

Notes & Next Steps
- Jobs and resumes are demo-backed; to complete the flow: persist `Job` and `Application` models, associate jobs with employer users, and store resumes on the user's model.
- Consider extracting shared job components into partials for reuse between applicant and employer views.
