<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

Route::middleware(['auth', 'role:employer', 'approved'])->get('employer/home', [JobController::class, 'employerHome'])->name('employer.home');
Route::view('/', 'landing')->name('landing');

// Auth
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Jobs
Route::get('jobs', [JobController::class, 'publicJobs'])->name('jobs.public');
Route::middleware(['auth', 'role:applicant,employer'])->group(function () {
    Route::get('applicant/jobs', [JobController::class, 'applicantJobs'])->name('jobs.applicant');
    Route::get('home', [JobController::class, 'index'])->name('jobs.index');
    Route::get('job/show/{id}', [JobController::class, 'show'])->name('jobs.show');
});

Route::middleware(['auth', 'role:employer', 'approved'])->group(function(){
    Route::get('job', [JobController::class, 'hub'])->name('jobs.hub');

    Route::get('job/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('job/create', [JobController::class, 'store'])->name('jobs.store');
    Route::get('job/edit/{id}', [JobController::class, 'edit'])->name('jobs.edit');
    Route::post('job/edit/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::post('job/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
});

// Profiles
Route::middleware(['auth', 'role:applicant,employer'])->group(function(){
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/resume', [ProfileController::class, 'downloadResume'])->name('profile.resume');
    Route::get('profile/resume/preview', [ProfileController::class, 'previewResume'])->name('profile.resume.preview');
});

// Applications
Route::middleware(['auth', 'role:applicant,employer'])->group(function(){
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('job/apply/{id}', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('applications/review/{id}', [ApplicationController::class, 'review'])->name('applications.review');
    Route::post('applications/review/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('applications/review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'applicant'])->name('applications.applicant');
    Route::get('applications/review/{jobId}/applicant/{applicantId}/resume', [ApplicationController::class, 'resume'])->name('applications.applicant.resume');
    Route::get('applications/review/{jobId}/applicant/{applicantId}/resume/preview', [ApplicationController::class, 'previewResume'])->name('applications.applicant.resume.preview');
    Route::post('applications/review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'updateApplicantStatus'])->name('applications.applicant.updateStatus');
    Route::post('applications/review/{jobId}/applicant/{applicantId}/email', [ApplicationController::class, 'emailApplicant'])->name('applications.email');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::middleware('auth')->get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Admin
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('admin/moderate/{id}', [AdminController::class, 'moderateJob'])->name('admin.jobs.moderate');
});

// Fallback
Route::fallback(function () {
    return view('errors.404');
});