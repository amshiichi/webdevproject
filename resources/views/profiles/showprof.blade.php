@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

@php
use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* Premium Royal Blue & White Palette Configuration */
    :root {
        --royal-blue-deep: #0f1e46;
        --royal-blue-main: #1e40af;
        --royal-blue-bright: #2563eb;
        --royal-blue-light: #eff6ff;
        --royal-blue-tint: #dbeafe;
        --pure-white: #ffffff;
    }

    /* Global upscaling & layout containment */
    .profile-wrapper {
        max-width: 1100px;
        margin: 60px auto 100px auto;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .profile-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        padding: 56px;
        border-radius: 32px;
        box-shadow: 0 15px 35px rgba(30, 64, 175, 0.04);
    }

    /* Avatar & Header Elements */
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--royal-blue-main);
        color: var(--pure-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 54px;
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.15);
    }

    .profile-name {
        font-size: 38px;
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .profile-meta-text {
        color: var(--royal-blue-main);
        font-size: 18px;
        font-weight: 500;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Section Content Styles */
    .profile-section-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 48px;
        margin-top: 40px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--royal-blue-deep);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .body-text {
        color: var(--royal-blue-deep);
        opacity: 0.85;
        font-size: 17px;
        line-height: 1.7;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 17px;
        color: var(--royal-blue-deep);
        font-weight: 500;
        margin-bottom: 16px;
    }

    .contact-icon {
        font-size: 20px;
        color: var(--royal-blue-bright);
    }

    /* Premium Custom Badges */
    .skill-badge {
        background: var(--royal-blue-light);
        color: var(--royal-blue-main);
        border: 2px solid var(--royal-blue-tint);
        font-size: 16px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .skill-badge:hover {
        background: var(--royal-blue-main);
        color: var(--pure-white);
        border-color: var(--royal-blue-main);
    }

    /* Premium Button Overrides */
    .btn-royal-primary {
        background: var(--royal-blue-bright);
        color: var(--pure-white);
        font-weight: 600;
        font-size: 16px;
        padding: 14px 28px;
        border-radius: 12px;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-royal-primary:hover {
        background: var(--royal-blue-main);
        color: var(--pure-white);
        transform: scale(1.02);
    }

    .btn-royal-outline {
        background: transparent;
        color: var(--royal-blue-bright);
        border: 2px solid var(--royal-blue-bright);
        font-weight: 600;
        font-size: 16px;
        padding: 14px 28px;
        border-radius: 12px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-royal-outline:hover {
        background: var(--royal-blue-light);
        color: var(--royal-blue-main);
    }

    .custom-hr {
        border: 0;
        border-top: 2px solid var(--royal-blue-light);
        margin: 40px 0;
    }
</style>

<div class="profile-wrapper">
    <div class="profile-card">
        @if (session('success'))
            <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @php($isEmployer = $user->role === 'employer')

        <div style="display:flex; gap:32px; align-items:center; flex-wrap:wrap;">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div style="flex: 1;">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-meta-text">
                    <i class="bi bi-briefcase-fill"></i>
                    {{ $isEmployer ? 'Employer' : 'Applicant' }}
                </p>
                @if ($user->location)
                    <p class="profile-meta-text" style="margin-top: 6px; opacity: 0.8;">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $user->location }}
                    </p>
                @endif
            </div>

            <a href="{{ route('profile.edit') }}" class="btn btn-royal-primary">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Profile
            </a>
        </div>

        <hr class="custom-hr">

        <div class="profile-section-grid">
            <div>
                <h3 class="section-title">
                    <i class="bi bi-person-lines-fill"></i>
                    {{ $isEmployer ? 'About Us' : 'About' }}
                </h3>
                <p class="body-text">
                    {{ $user->bio ?: 'No bio added yet.' }}
                </p>
            </div>

            <div>
                <h3 class="section-title">
                    <i class="bi bi-envelope-paper-fill"></i>
                    Contact Information
                </h3>
                <div class="contact-item">
                    <i class="bi bi-envelope-fill contact-icon"></i>
                    <span>{{ $user->email }}</span>
                </div>
                @if ($user->phone)
                    <div class="contact-item">
                        <i class="bi bi-telephone-fill contact-icon"></i>
                        <span>{{ $user->phone }}</span>
                    </div>
                @endif
                @if ($user->location)
                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill contact-icon"></i>
                        <span>{{ $user->location }}</span>
                    </div>
                @endif
            </div>
        </div>

        <hr class="custom-hr">

        @if ($isEmployer)
            <div>
                <h3 class="section-title">
                    <i class="bi bi-star-fill"></i>
                    Company Reviews
                </h3>
                <p class="body-text">Company review tracking is coming soon.</p>
            </div>
        @else
            <div>
                <h3 class="section-title">
                    <i class="bi bi-file-earmark-person-fill"></i>
                    Resume
                </h3>
                <p class="body-text" style="margin-bottom: 24px;">
                    Upload and manage your resume to make it easier for employers to view your qualifications.
                </p>
                @if ($user->resume_path)
                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <a href="{{ route('profile.resume') }}" class="btn btn-royal-outline">
                            <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                            Download Resume
                        </a>
                        <button onclick="document.getElementById('profile-resume-modal').style.display='flex'" class="btn btn-royal-outline">
                            <i class="bi bi-eye me-2"></i>
                            Preview Resume
                        </button>
                    </div>
                @else
                    <span class="btn btn-royal-outline" style="opacity:.6; pointer-events:none;">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                        Edit Profile to Upload Resume
                    </span>
                @endif
            </div>

            <hr class="custom-hr">

            <div>
                <h3 class="section-title">
                    <i class="bi bi-stars"></i>
                    Skills
                </h3>
                @if ($user->skills)
                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top: 16px;">
                        @foreach (explode(',', $user->skills) as $skill)
                            <span class="skill-badge">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="body-text">No skills added yet.</p>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- Resume Preview Modal --}}
<div id="profile-resume-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:24px;width:95%;max-width:860px;height:90vh;display:flex;flex-direction:column;box-shadow:0 24px 60px rgba(15,23,42,.2);font-family:'Inter',sans-serif;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h2 style="margin:0;font-family:'Poppins',sans-serif;color:#0f1e46;font-size:1.3rem;">Your Resume</h2>
            <button onclick="document.getElementById('profile-resume-modal').style.display='none'"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#64748b;">✕</button>
        </div>
        <iframe src="{{ route('profile.resume.preview') }}"
            style="flex:1;border:1px solid #e5e7eb;border-radius:10px;width:100%;"
            type="application/pdf">
            <p>Your browser cannot display PDFs inline. <a href="{{ route('profile.resume') }}">Download instead.</a></p>
        </iframe>
    </div>
</div>
@endsection