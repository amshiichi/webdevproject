<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# webdevproject

## Laravel Stuff

placeholder

## Getting Started

placeholder

## About ApplyHub

placeholder

## Features

placeholder

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


## Project Structure

.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php         # Moderation dashboard; approve / reject listings
│   │   │   ├── ApplicationController.php   # Apply to jobs, review applicants, update statuses,
│   │   │   │                               #   email applicants, résumé download + preview
│   │   │   ├── AuthController.php          # Login, registration, logout, role-aware redirect
│   │   │   ├── JobController.php           # Job feed (public + applicant), employer hub,
│   │   │   │                               #   create / edit / delete listings, job detail
│   │   │   ├── NotificationController.php  # Notification feed, mark-read, delete
│   │   │   └── ProfileController.php       # View / edit profile, résumé upload + download
│   │   └── Middleware/
│   │       ├── AccountApproved.php         # Blocks unapproved / suspended employer accounts
│   │       └── UserRolePermission.php      # Role-based route access (applicant / employer / admin)
│   ├── Models/
│   │   ├── Application.php                 # Belongs to applicant (User) and JobListing
│   │   ├── JobListing.php                  # Belongs to employer (User); has many Applications
│   │   ├── Notification.php                # Belongs to User; stores message + optional link
│   │   └── User.php                        # Has many JobListings, Applications, Notifications;
│   │                                       #   stores role, account_status, and résumé path
│   └── Providers/
│       └── AppServiceProvider.php
│
├── resources/
│   ├── css/                                # Compiled app stylesheet entry point
│   ├── js/                                 # Vite build entry points (Bootstrap JS)
│   ├── sass/                               # Bootstrap-based Sass variables + app styles
│   └── views/
│       ├── landing.blade.php               # Role-selection landing page
│       ├── welcome.blade.php               # Default Laravel welcome (unused in production)
│       ├── layouts/
│       │   └── app.blade.php               # Shared base layout (nav, flash messages)
│       ├── auth/
│       │   ├── login.blade.php             # Shared login form
│       │   └── register.blade.php          # Registration with role picker
│       ├── jobs/
│       │   ├── index.blade.php             # Default authenticated job index
│       │   ├── public.blade.php            # Unauthenticated public job board
│       │   ├── applicant.blade.php         # Applicant-facing job feed with stat cards
│       │   ├── show.blade.php              # Job detail + apply button
│       │   └── form.blade.php              # Create / edit job listing (shared form)
│       ├── applicant/
│       │   └── home.blade.php              # Applicant home with feed + recommended jobs
│       ├── applications/
│       │   ├── applications.blade.php      # Applicant's submitted applications list
│       │   └── applicant-detail.blade.php  # Employer's detailed view of one applicant
│       ├── employer/
│       │   ├── home.blade.php              # Employer home with summary stat cards
│       │   ├── hub.blade.php               # Employer's job listing hub
│       │   ├── dashboard.blade.php         # Employer application dashboard
│       │   └── review.blade.php            # Per-job applicant review table
│       ├── admin/
│       │   └── dashboard.blade.php         # Moderation panel (pending / approved / rejected tabs)
│       ├── profiles/
│       │   ├── showprof.blade.php          # Public profile view
│       │   └── editprof.blade.php          # Profile + résumé edit form
│       ├── notifications/
│       │   └── index.blade.php             # Notification feed
│       └── errors/
│           └── 404.blade.php               # Custom 404 page
│
├── database/
│   ├── migrations/
│   │   ├── create_cache_table.php
│   │   ├── create_jobs_table.php           # Laravel queue jobs table
│   │   ├── create_job_listings_table.php   # title, company, location, type, salary, status
│   │   ├── create_users_table.php          # role, account_status, profile fields, résumé path
│   │   ├── create_notifications_table.php  # user_id, message, link, is_read
│   │   └── create_applications_table.php   # applicant_id, job_listing_id, status
│   └── seeders/
│       ├── DatabaseSeeder.php              # Seeds admin, employer, and applicant test users
│       └── JobListingSeeder.php            # Seeds sample job listings
│
└── routes/
    ├── web.php                             # All application routes grouped by role
    └── auth.php                            # Laravel UI auth routes (login, register, logout)


## License

This project is licensed under the MIT License.

ApplyHub is a web-based job portal system developed as a final project for **COMP016: Web Development** under the **Bachelor of Science in Computer Science** program at **Polytechnic University of the Philippines (PUP) Sta. Mesa, Manila, Mabini Campus** for Academic Year 2025–2026.

The system was built using Laravel 12 and other open-source technologies. Laravel is distributed under the MIT License.
