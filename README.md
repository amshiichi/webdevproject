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

placeholder

## License

This project is built using Laravel, a PHP web application framework known for its expressive and elegant syntax. Laravel provides features such as routing, dependency injection, database ORM, schema migrations, session and cache management, queue processing, and event broadcasting. These tools help simplify web application development and support the creation of scalable and maintainable systems.

placeholder
