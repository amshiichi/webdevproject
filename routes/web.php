<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

// Auth
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Jobs
Route::get('home', [JobController::class, 'index'])->name('jobs.index');
Route::get('job/show/{id}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'role:employer'])->group(function(){
    Route::get('job/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('job/create', [JobController::class, 'store'])->name('jobs.store');
    Route::get('job/show/{id}', [JobController::class, 'show'])->name('jobs.show');
    Route::get('job/edit/{id}', [JobController::class, 'edit'])->name('jobs.edit');
    Route::post('job/edit/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::post('job/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
});


// Profiles
Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/edit', [ProfileController::class, 'update'])->name('profile.update');

// Applications
Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::post('job/apply/{id}', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('applications/review/{id}', [ApplicationController::class, 'review'])->name('applications.review');
Route::post('applications/review/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

// Admin
Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('admin/moderate/{id}', [AdminController::class, 'moderateJob'])->name('admin.jobs.moderate');

// Fallback
Route::fallback(function () {
    return 'Placeholder Text: Page Not Found.';
});