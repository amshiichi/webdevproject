<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# webdevproject

## Getting Started
Welcome to ApplyHub, a Laravel-based job portal system. Follow the steps below to set it up on your local machine:
```bash
# 1. Clone the repository

# 2. Install PHP dependencies
composer install

# 3. Configure environment and generate key
copy .env.example .env
php artisan key:generate

# 4. Run migrations and seed for sample job data
php artisan migrate:fresh --seed 

# 5. Start the server
php artisan serve
```

## About ApplyHub

placeholder

## Features

Authentication & Registration

•	Shared login page with role-aware redirection (applicant → job feed, employer → dashboard, admin → moderation panel)

•	Registration with role selection (applicant or employer); employer accounts are held in pending status until admin approval

•	Session-based auth with remember-me support and CSRF protection

Applicant Portal

•	Job feed - browse all approved listings with live filters for keyword, location, job type (full-time / part-time / contract / internship), and experience level (entry / mid / senior)

•	Job detail view - full description, requirements, company, salary range, and a single-click apply button

•	One-click apply - submits an application; duplicate applications and resume-less applies are blocked with inline error messages

•	Application tracker - lists all submitted applications with current status (Pending → Interview → Hired / Rejected)

•	Recommended jobs - a small curated set of randomly surfaced listings shown on the home feed

•	Profile & résumé - edit personal info (bio, phone, location, education, experience, skills) and upload a PDF résumé; résumé can be previewed in-browser or downloaded

Employer Portal

•	Employer home - summary cards for total job posts, pending/approved counts, total applications, and pending applications

•	Job hub - list of all employer-owned postings with status badges and quick-action links

•	Create / edit job listings - form-validated fields: title, description, requirements, company, location, salary range, job type, and experience level; new posts enter pending moderation

•	Delete listings - soft-remove a job posting (owner-only, 403 on mismatch)

•	Applicant review - per-job table of all applicants with their current stage and shortlisted count

•	Applicant detail - full applicant profile, in-browser résumé preview, and résumé download

•	Status management - update posting status (Live / Screening / Closed) and individual applicant status (Pending / Interview / Hired / Rejected); every status change fires an in-app notification to the applicant

•	Email applicant - compose and send a free-form email to an applicant directly from the review panel; a notification copy lands in the applicant's notification feed

Admin Panel

•	Moderation dashboard - tabbed view of Pending, Approved, and Rejected job postings

•	Approve / Reject - one-click moderation decision; employer receives an in-app notification with a link to the listing

Notifications

•	In-app notification feed for all three roles (new application, status changes, posting decisions, employer emails)

•	Mark-as-read via AJAX (JSON response) or standard redirect

•	Delete individual notifications

Access Control & Middleware

•	UserRolePermission - variadic role guard; routes declare which roles are allowed and 403 on mismatch

•	AccountApproved - blocks employers whose account is still pending or has been suspended; logs them out and redirects to login with a descriptive error message


## Tech Stack

| Layer                   | Technology                       |
| ----------------------- | -------------------------------- |
| Language                | PHP, JavaScript, HTML5, CSS3     |
| Backend                 | Laravel 12                       |
| Frontend                | Blade Templates                  |
| Styling                 | Bootstrap 5, Tailwind CSS 4      |
| Database                | SQLite                           |
| Build Tools             | Vite 8, NPM                      |
| Dependency Management   | Composer                         |
| Development Environment | Visual Studio Code               |
| Tools (VSC Extension)   | SQLite Viewer (Florian Klampfer) |
| Version Control         | Git, GitHub                      |


## Routes

### Public Routes

| Method | URL       | Description         |
| ------ | --------- | ------------------- |
| GET    | /         | Landing page        |
| GET    | /login    | Login page          |
| POST   | /login    | User authentication |
| GET    | /register | Registration page   |
| POST   | /register | User registration   |
| GET    | /jobs     | Public job listings |

### Authenticated Users (Applicant & Employer)

| Method | URL                       | Description               |
| ------ | ------------------------- | ------------------------- |
| POST   | /logout                   | Logout current user       |
| GET    | /home                     | User dashboard            |
| GET    | /applicant/jobs           | Browse available jobs     |
| GET    | /job/show/{id}            | View job details          |
| POST   | /job/apply/{id}           | Submit job application    |
| GET    | /profile                  | View profile              |
| GET    | /profile/edit             | Edit profile              |
| POST   | /profile/edit             | Update profile            |
| GET    | /profile/resume           | Download resume           |
| GET    | /profile/resume/preview   | Preview resume            |
| GET    | /applications             | View applications         |
| GET    | /applications/review/{id} | Review application        |
| POST   | /applications/review/{id} | Update application status |
| GET    | /notifications            | View notifications        |
| POST   | /notifications/{id}/read  | Mark notification as read |
| DELETE | /notifications/{id}       | Delete notification       |

### Employer Routes

| Method | URL                                                                 | Description               |
| ------ | ------------------------------------------------------------------- | ------------------------- |
| GET    | /employer/home                                                      | Employer dashboard        |
| GET    | /job                                                                | Job management hub        |
| GET    | /job/create                                                         | Create job posting        |
| POST   | /job/create                                                         | Store job posting         |
| GET    | /job/edit/{id}                                                      | Edit job posting          |
| POST   | /job/edit/{id}                                                      | Update job posting        |
| POST   | /job/delete/{id}                                                    | Delete job posting        |
| GET    | /applications/review/{jobId}/applicant/{applicantId}                | View applicant profile    |
| GET    | /applications/review/{jobId}/applicant/{applicantId}/resume         | Download applicant resume |
| GET    | /applications/review/{jobId}/applicant/{applicantId}/resume/preview | Preview applicant resume  |
| POST   | /applications/review/{jobId}/applicant/{applicantId}                | Update applicant status   |
| POST   | /applications/review/{jobId}/applicant/{applicantId}/email          | Email applicant           |

### Administrator Routes

| Method | URL                  | Description                       |
| ------ | -------------------- | --------------------------------- |
| GET    | /admin/dashboard     | Administrative dashboard          |
| POST   | /admin/moderate/{id} | Moderate and approve job postings |

### Error Handling

| Method | URL | Description                          |
| ------ | --- | ------------------------------------ |
| ANY    | *   | Custom 404 page for undefined routes |


## Database Design

### 'users' Table

| Attribute | Description |
| ------ | ----------- |
| `id` | Auto-increment primary key |
| `name` | Full name of applicant |
| `email` | Unique email address) |
| `email_verified_at` | Email verification timestamp |
| `role` | User role (applicant, employer, admin) |
| `bio` | Short biography |
| `phone` | Contact number |
| `location` | Location |
| `education` | Latest educational background |
| `skills` | Comma-separated skills |
| `experience` | Work experience |
| `resume_path` | Path to uploaded resume|
| `password` | Hashed password |
| `account_status` | Account status (pending, approved, suspended) |
| `remember_token` | Remember-me token |
| `created_at` / `updated_at` | Timestamps |

### 'job_listings' Table

| Column | Description |
| ------ | ----------- |
| `id` | Auto-increment primary key |
| `employer_id` | Owning employer (FK) |
| `title` | Job title |
| `description` | Job description |
| `requirements` | Job requirements |
| `company` | Company name |
| `location` | Job location |
| `salary_min` | Minimum salary |
| `salary_max` | Maximum salary |
| `type` | Employment type (full-time, part-time, contractual, internship |
| `experience_level` | Required experience level (entry level, mid level, senior level) |
| posting_status` | Employer-managed status (live, screening, closed) |
| `status` | Admin-managed status (pending, approved, rejected) |
| `created_at` / `updated_at` | Timestamps |

### 'applications' Table

| Column | Description |
| ------ | ----------- |
| `id` | Auto-increment primary key |
| `applicant_id` | Applying user (FK) |
| `job_listing_id` | Target job listing (FK) |
| `status` | Application status (pending, interview, accepted, rejected)|
| `created_at` / `updated_at` | Timestamps |

### 'notifications' table

| Column | Description |
| ------ | ----------- |
| `id` | Auto-increment primary key |
| `user_id` | Recipient user (FK) |
| `message` | Notification message |
| `link` | Optional action link to specific notification |
| `is_read` | Read status (default: false) |
| `created_at` / `updated_at` | Timestamps |

### Enums

| Enum | Valid Values |
| ---- | ------------ |
| `users.role` | `applicant`, `employer`, `admin` |
| `users.account_status` | `pending`, `approved`, `suspended` |
| `job_listings.type` | `Full-time`, `Part-time`, `Contractual`, `Internship` |
| `job_listings.experience_level` | `Entry Level`, `Mid Level`, `Senior Level` |
| `job_listings.posting_status` | `live`, `screening`, `closed` |
| `job_listings.status` | `pending`, `approved`, `rejected` |
| `applications.status` | `pending`, `interview`, `accepted`, `rejected` |

## Project Structure
```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── ApplicationController.php
│   │   │   ├── AuthController.php
│   │   │   ├── Controller.php
│   │   │   ├── JobController.php
│   │   │   ├── NotificationController.php
│   │   │   └── ProfileController.php
│   │   │
│   │   └── Middleware/
│   │       ├── AccountApproved.php
│   │       └── UserRolePermission.php
│   │
│   ├── Models/
│   │   ├── Application.php
│   │   ├── JobListing.php
│   │   ├── Notification.php
│   │   └── User.php
│   │
│   └── Providers/
│       └── AppServiceProvider.php
│
├── bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
│
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   │
│   ├── migrations/
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_06_21_193119_create_job_listings_table.php
│   │   ├── 2026_06_22_093937_create_users_table.php
│   │   ├── 2026_06_22_135513_create_notifications_table.php
│   │   └── 2026_06_23_000000_create_applications_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── JobListingSeeder.php
│
├── public/
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
│
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   ├── sass/
│   │   ├── _variables.scss
│   │   └── app.scss
│   │
│   └── views/
│       ├── landing.blade.php
│       ├── welcome.blade.php
│       │
│       ├── layouts/
│       │   └── app.blade.php
│       │
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── jobs/
│       │   ├── applicant.blade.php
│       │   ├── form.blade.php
│       │   ├── index.blade.php
│       │   ├── public.blade.php
│       │   └── show.blade.php
│       │
│       ├── applicant/
│       │   └── home.blade.php
│       │
│       ├── employer/
│       │   ├── dashboard.blade.php
│       │   ├── home.blade.php
│       │   ├── hub.blade.php
│       │   └── review.blade.php
│       │
│       ├── admin/
│       │   └── dashboard.blade.php
│       │
│       ├── applications/
│       │   ├── applicant-detail.blade.php
│       │   └── applications.blade.php
│       │
│       ├── profiles/
│       │   ├── editprof.blade.php
│       │   └── showprof.blade.php
│       │
│       ├── notifications/
│       │   └── index.blade.php
│       │
│       └── errors/
│           └── 404.blade.php
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── tests/
│   ├── TestCase.php
│   └── Unit/
│       └── ExampleTest.php
│
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── vite.config.js
├── README.md
├── README_APPLICANT.md
└── README_EMPLOYER.md
```

## License

This project is licensed under the MIT License.

ApplyHub is a web-based job portal system developed as a final project for **COMP016: Web Development** under the **Bachelor of Science in Computer Science** program at **Polytechnic University of the Philippines (PUP) Sta. Mesa, Manila, Mabini Campus** for Academic Year 2025–2026.

The system was built using Laravel 12 and other open-source technologies. Laravel is distributed under the MIT License.
