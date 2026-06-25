<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

Route::view('/', 'landing')->name('landing');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('jobs', [JobController::class, 'publicJobs'])->name('jobs.public');
Route::get('home', [JobController::class, 'index'])->name('jobs.index')->middleware(['auth', 'role:applicant,employer']);
Route::get('applicant/jobs', [JobController::class, 'applicantJobs'])->name('jobs.applicant')->middleware(['auth', 'role:applicant,employer']);
Route::get('employer/home', [JobController::class, 'employerHome'])->name('employer.home')->middleware(['auth', 'role:employer', 'approved']);

Route::group(['prefix' => 'job'], function(){
    Route::get('show/{id}', [JobController::class, 'show'])->name('jobs.show')->middleware(['auth', 'role:applicant,employer']);
    Route::get('/', [JobController::class, 'hub'])->name('jobs.hub')->middleware(['auth', 'role:employer', 'approved']);
    Route::get('create', [JobController::class, 'create'])->name('jobs.create')->middleware(['auth', 'role:employer', 'approved']);
    Route::post('create', [JobController::class, 'store'])->name('jobs.store')->middleware(['auth', 'role:employer', 'approved']);
    Route::get('edit/{id}', [JobController::class, 'edit'])->name('jobs.edit')->middleware(['auth', 'role:employer', 'approved']);
    Route::post('edit/{id}', [JobController::class, 'update'])->name('jobs.update')->middleware(['auth', 'role:employer', 'approved']);
    Route::post('delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy')->middleware(['auth', 'role:employer', 'approved']);
    Route::post('apply/{id}', [ApplicationController::class, 'store'])->name('applications.store')->middleware(['auth', 'role:applicant,employer']);
});

Route::group(['prefix' => 'profile'], function(){
    Route::get('/', [ProfileController::class, 'show'])->name('profile.show')->middleware(['auth', 'role:applicant,employer']);
    Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth', 'role:applicant,employer']);
    Route::post('edit', [ProfileController::class, 'update'])->name('profile.update')->middleware(['auth', 'role:applicant,employer']);
    Route::get('resume', [ProfileController::class, 'downloadResume'])->name('profile.resume')->middleware(['auth', 'role:applicant,employer']);
    Route::get('resume/preview', [ProfileController::class, 'previewResume'])->name('profile.resume.preview')->middleware(['auth', 'role:applicant,employer']);
});

Route::group(['prefix' => 'applications'], function(){
    Route::get('/', [ApplicationController::class, 'index'])->name('applications.index')->middleware(['auth', 'role:applicant,employer']);
    Route::get('review/{id}', [ApplicationController::class, 'review'])->name('applications.review')->middleware(['auth', 'role:applicant,employer']);
    Route::post('review/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus')->middleware(['auth', 'role:applicant,employer']);
    Route::get('review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'applicant'])->name('applications.applicant')->middleware(['auth', 'role:applicant,employer']);
    Route::get('review/{jobId}/applicant/{applicantId}/resume', [ApplicationController::class, 'resume'])->name('applications.applicant.resume')->middleware(['auth', 'role:applicant,employer']);
    Route::get('review/{jobId}/applicant/{applicantId}/resume/preview', [ApplicationController::class, 'previewResume'])->name('applications.applicant.resume.preview')->middleware(['auth', 'role:applicant,employer']);
    Route::post('review/{jobId}/applicant/{applicantId}', [ApplicationController::class, 'updateApplicantStatus'])->name('applications.applicant.updateStatus')->middleware(['auth', 'role:applicant,employer']);
    Route::post('review/{jobId}/applicant/{applicantId}/email', [ApplicationController::class, 'emailApplicant'])->name('applications.email')->middleware(['auth', 'role:applicant,employer']);
});

Route::group(['prefix' => 'notifications'], function(){
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index')->middleware('auth');
    Route::post('{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read')->middleware(['auth', 'role:applicant,employer']);
    Route::delete('{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware(['auth', 'role:applicant,employer']);
});

Route::group(['prefix' => 'admin'], function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);
    Route::post('moderate/{id}', [AdminController::class, 'moderateJob'])->name('admin.jobs.moderate')->middleware(['auth', 'role:admin']);
});

Route::fallback(function(){
    return view('errors.404');
});