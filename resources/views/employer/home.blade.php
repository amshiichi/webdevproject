@extends('layouts.app')
@section('title', 'Employer Home')
@section('content')
<style>
    :root {
        --royal-blue-deep: #0f1e46;
        --royal-blue-main: #1e40af;
        --royal-blue-bright: #2563eb;
        --royal-blue-light: #eff6ff;
        --royal-blue-tint: #dbeafe;
        --pure-white: #ffffff;
        --muted: #64748b;
    }

    .employer-wrap {
        max-width: 1360px;
        margin: 0 auto;
        padding: 56px 32px 100px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 28px;
        align-items: stretch;
        margin-bottom: 28px;
    }

    .hero-card,
    .side-card,
    .section-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 28px;
        box-shadow: 0 18px 44px rgba(30, 64, 175, 0.06);
    }

    .hero-card {
        padding: 42px;
        background: linear-gradient(135deg, #102a72 0%, #2563eb 100%);
        color: #fff;
        overflow: hidden;
        position: relative;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        right: -90px;
        top: -90px;
        width: 240px;
        height: 240px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.10);
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255,255,255,0.12);
        font-weight: 700;
    }

    .hero-card h1 {
        margin: 18px 0 12px;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2.7rem, 5vw, 4.6rem);
        line-height: 0.96;
        letter-spacing: -0.05em;
        max-width: 11ch;
        color: #fff;
    }

    .hero-card p {
        margin: 0;
        max-width: 720px;
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.95);
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
        position: relative;
        z-index: 1;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 999px;
        font-weight: 800;
        border: 1px solid transparent;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .button:hover { transform: translateY(-1px); }
    .button-primary {
        background: #fff;
        color: var(--royal-blue-deep);
        box-shadow: 0 14px 28px rgba(0,0,0,.12);
    }
    .button-ghost {
        color: #fff;
        border-color: rgba(255,255,255,.25);
        background: rgba(255,255,255,.08);
    }

    .button-soft {
        color: #fff;
        border-color: rgba(255,255,255,.22);
        background: rgba(255,255,255,.14);
    }

    .button-soft:hover {
        background: rgba(255,255,255,.22);
    }

    .side-card {
        padding: 28px;
        display: grid;
        gap: 16px;
        align-content: start;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .stat {
        border-radius: 22px;
        background: var(--royal-blue-light);
        padding: 20px;
    }

    .stat strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        color: var(--royal-blue-deep);
        margin-bottom: 6px;
    }

    .stat span { color: var(--muted); font-weight: 600; }

    .section {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 24px;
        margin-top: 24px;
    }

    .section-card {
        padding: 28px;
    }

    .section-card h2 {
        margin: 0 0 8px;
        font-family: 'Poppins', sans-serif;
        color: var(--royal-blue-deep);
        font-size: 1.7rem;
    }

    .section-card p.sub {
        margin: 0 0 22px;
        color: var(--muted);
    }

    .quick-list {
        display: grid;
        gap: 14px;
    }

    .quick-item {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        padding: 18px 20px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid var(--royal-blue-light);
    }

    .quick-item strong { display: block; color: var(--royal-blue-deep); font-size: 1.05rem; }
    .quick-item span { color: var(--muted); font-size: 0.95rem; }

    .side-stack {
        display: grid;
        gap: 14px;
    }

    .mini-card {
        padding: 20px;
        border-radius: 18px;
        background: var(--royal-blue-light);
    }

    .mini-card strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 1.15rem;
        margin-bottom: 6px;
        color: var(--royal-blue-deep);
    }

    .mini-card p { margin: 0; color: var(--muted); line-height: 1.6; }

    @media (max-width: 960px) {
        .hero,
        .section { grid-template-columns: 1fr; }
        .employer-wrap { padding: 32px 20px 80px; }
    }
</style>

<div class="employer-wrap">
    <div class="hero">
        <section class="hero-card">
            <div class="eyebrow"><i class="bi bi-building-check"></i> Employer dashboard</div>
            <h1>Post jobs and manage hiring from one place.</h1>
            <p>
                Create new listings, review hiring activity, and move straight into the job posting form.
            </p>

            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('jobs.hub') }}"><i class="bi bi-briefcase-fill"></i> Job</a>
                <a class="button button-soft" href="{{ route('jobs.edit', 1) }}"><i class="bi bi-pencil-square"></i> Edit Job Post</a>
                <a class="button button-ghost" href="{{ route('applications.index') }}"><i class="bi bi-inboxes-fill"></i> View Applications</a>
            </div>
        </section>

        <aside class="side-card">
            <div class="stat-grid">
                <div class="stat"><strong>14</strong><span>jobs posted</span></div>
                <div class="stat"><strong>36</strong><span>new applicants</span></div>
                <div class="stat"><strong>8</strong><span>draft roles</span></div>
                <div class="stat"><strong>3</strong><span>jobs pending</span></div>
            </div>
            <div class="mini-card">
                <strong>Quick tip</strong>
                <p>Keep your title clear, add salary ranges, and publish a concise job description to get stronger applicant matches.</p>
            </div>
        </aside>
    </div>

    <div class="section">
        <section class="section-card">
            <h2>Fast actions</h2>
            <p class="sub">Jump into the most common employer tasks.</p>
            <div class="quick-list">
                <div class="quick-item">
                    <div>
                        <strong>Create a new job post</strong>
                        <span>Open the job form and publish a new listing.</span>
                    </div>
                    <a class="button button-primary" href="{{ route('jobs.create') }}">Create</a>
                </div>
                <div class="quick-item">
                    <div>
                        <strong>Review incoming applications</strong>
                        <span>Check applicant submissions and status updates.</span>
                    </div>
                    <a class="button button-primary" href="{{ route('applications.index') }}">Review</a>
                </div>
                <div class="quick-item">
                    <div>
                        <strong>Edit an existing job</strong>
                        <span>Update descriptions, salary, or posting details.</span>
                    </div>
                    <a class="button button-primary" href="{{ route('jobs.edit', 1) }}">Edit</a>
                </div>
            </div>
        </section>

        <section class="section-card">
            <h2>Publishing checklist</h2>
            <p class="sub">A simple flow for employers before posting a role.</p>
            <div class="quick-list">
                <div class="mini-card">
                    <strong>1. Write the title</strong>
                    <p>Use a clear, searchable job title that matches the role you need to fill.</p>
                </div>
                <div class="mini-card">
                    <strong>2. Add the details</strong>
                    <p>Include location, job type, salary range, and responsibilities in the form.</p>
                </div>
                <div class="mini-card">
                    <strong>3. Publish and track</strong>
                    <p>Submit the listing, then review applicants and manage the hiring flow.</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
