@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
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
        @php($isEmployer = session('account_role') === 'employer')

        <div style="display:flex; gap:32px; align-items:center; flex-wrap:wrap;">
            
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div style="flex: 1;">
                <h1 class="profile-name">
                    {{ $isEmployer ? 'Nova Studio' : 'Juan Dela Cruz' }}
                </h1>
                <p class="profile-meta-text">
                    <i class="bi bi-briefcase-fill"></i>
                    {{ $isEmployer ? 'Employer' : 'Applicant' }}
                </p>
                <p class="profile-meta-text" style="margin-top: 6px; opacity: 0.8;">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ $isEmployer ? 'Makati, PH' : 'Manila, PH' }}
                </p>
            </div>

            <a href="{{ url('/profile/edit') }}" class="btn btn-royal-primary">
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
                    {{ $isEmployer
                        ? 'Nova Studio is a product design and development company focused on building modern digital experiences for growing businesses.'
                        : 'Passionate developer with 3+ years of experience in web technologies, software development, and problem-solving. Skilled in creating modern, responsive, and user-friendly applications.' }}
                </p>
            </div>

            <div>
                <h3 class="section-title">
                    <i class="bi bi-envelope-paper-fill"></i>
                    {{ $isEmployer ? 'Contact Information' : 'Contact Information' }}
                </h3>

                <div class="contact-item">
                    <i class="bi bi-envelope-fill contact-icon"></i>
                    <span>{{ $isEmployer ? 'hello@novastudio.com' : 'juan@email.com' }}</span>
                </div>

                <div class="contact-item">
                    <i class="bi bi-telephone-fill contact-icon"></i>
                    <span>{{ $isEmployer ? '+63 917 123 4567' : '+63 900 000 0000' }}</span>
                </div>

                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill contact-icon"></i>
                    <span>{{ $isEmployer ? 'Makati, Philippines' : 'Manila, Philippines' }}</span>
                </div>
            </div>
        </div>

        <hr class="custom-hr">

        @if ($isEmployer)
            <div>
                <h3 class="section-title">
                    <i class="bi bi-star-fill"></i>
                    Company Reviews
                </h3>
                <p class="body-text" style="margin-bottom: 24px;">
                    See feedback from applicants and keep your employer presence strong.
                </p>
                <div style="display:grid; gap:14px;">
                    <div class="card" style="border-left:4px solid var(--royal-blue-bright);">
                        <strong style="display:block; color:var(--royal-blue-deep); margin-bottom:6px;">4.8 / 5</strong>
                        <span style="color:var(--royal-blue-main);">Great communication and clear job posts.</span>
                    </div>
                    <div class="card" style="border-left:4px solid var(--royal-blue-main);">
                        <strong style="display:block; color:var(--royal-blue-deep); margin-bottom:6px;">4.6 / 5</strong>
                        <span style="color:var(--royal-blue-main);">Fast hiring process and responsive team.</span>
                    </div>
                </div>
            </div>
        @else
            @php($resumeUrl = session('resume_url'))
            @php($resumeName = session('resume_name', 'Uploaded Resume'))
            <div>
                <h3 class="section-title">
                    <i class="bi bi-file-earmark-person-fill"></i>
                    Resume
                </h3>
                <p class="body-text" style="margin-bottom: 24px;">
                    Upload and manage your resume to make it easier for employers to view your qualifications.
                </p>
                <a href="{{ $resumeUrl ?: '#' }}" class="btn btn-royal-outline" @if(! $resumeUrl) aria-disabled="true" style="pointer-events:none;opacity:.6;" @endif>
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                    {{ $resumeUrl ? 'Download Resume' : 'No Resume Uploaded' }}
                </a>
                @if ($resumeUrl)
                    <div class="body-text" style="margin-top: 12px; font-size: 15px; opacity: .9;">
                        Current file: {{ $resumeName }}
                    </div>
                @endif
            </div>
        @endif

        <hr class="custom-hr">

        @if (! $isEmployer)
            <div>
                <h3 class="section-title">
                    <i class="bi bi-stars"></i>
                    Skills
                </h3>
                <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top: 16px;">
                    <span class="skill-badge">HTML</span>
                    <span class="skill-badge">CSS</span>
                    <span class="skill-badge">JavaScript</span>
                    <span class="skill-badge">PHP</span>
                    <span class="skill-badge">Laravel</span>
                    <span class="skill-badge">MySQL</span>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection