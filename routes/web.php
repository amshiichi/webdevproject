<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

Route::view('employer/home', 'employer.home')->name('employer.home');
Route::view('/', 'landing')->name('landing');
Route::middleware('auth')->get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Auth
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Jobs
Route::view('jobs', 'jobs.public')->name('jobs.public');
Route::view('applicant/jobs', 'jobs.applicant')->name('jobs.applicant');
Route::get('home', [JobController::class, 'index'])->name('jobs.index');
Route::get('job/show/{id}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'role:employer'])->group(function(){
    Route::get('job', [JobController::class, 'hub'])->name('jobs.hub');

    Route::get('job/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('job/create', [JobController::class, 'store'])->name('jobs.store');
    Route::get('job/edit/{id}', [JobController::class, 'edit'])->name('jobs.edit');
    Route::post('job/edit/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::post('job/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
});

// Profiles
Route::middleware('auth')->group(function(){
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/edit', [ProfileController::class, 'update'])->name('profile.update');
});

// Applications
Route::middleware('auth')->group(function(){
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('job/apply/{id}', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('applications/review/{id}', [ApplicationController::class, 'review'])->name('applications.review');
    Route::post('applications/review/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('applications/review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'applicant'])->name('applications.applicant');
    Route::get('applications/review/{jobId}/applicant/{applicantId}/resume', [ApplicationController::class, 'resume'])->name('applications.applicant.resume');
    Route::post('applications/review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'updateApplicantStatus'])->name('applications.applicant.updateStatus');

});

// Admin
Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('admin/moderate/{id}', [AdminController::class, 'moderateJob'])->name('admin.jobs.moderate');

// Fallback
Route::fallback(function () {
    return 'Placeholder Text: Page Not Found.';
});