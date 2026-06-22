@extends('layouts.app')
@section('title', 'Applicant Jobs')
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

    .jobs-wrap {
        max-width: 1360px;
        margin: 0 auto;
        padding: 56px 32px 100px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 24px;
        align-items: start;
        margin-bottom: 26px;
    }

    .hero-card,
    .panel-card,
    .job-card {
        background: var(--pure-white);
        border: 1px solid rgba(16, 42, 114, 0.10);
        border-radius: 28px;
        box-shadow: 0 18px 44px rgba(16, 42, 114, 0.08);
    }

    .hero-card {
        padding: 40px;
        background: linear-gradient(135deg, #102a72 0%, #2563eb 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        right: -70px;
        top: -70px;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
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
        font-size: clamp(2.4rem, 5vw, 4.2rem);
        line-height: 0.96;
        letter-spacing: -0.05em;
        max-width: 12ch;
        color: #fff;
    }

    .hero-card p {
        margin: 0;
        max-width: 720px;
        font-size: 1.04rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.84);
    }

    .filters {
        display: grid;
        gap: 12px;
        margin-top: 24px;
        position: relative;
        z-index: 1;
    }

    .filters input,
    .filters select {
        width: 100%;
        padding: 14px 16px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.18);
        background: rgba(255,255,255,0.12);
        color: #fff;
        font: inherit;
    }

    .filters input::placeholder { color: rgba(255,255,255,0.72); }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 999px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
        white-space: nowrap;
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

    .panel-card {
        padding: 28px;
    }

    .panel-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .panel {
        padding: 18px;
        border-radius: 22px;
        background: var(--royal-blue-light);
    }

    .panel strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 1.9rem;
        color: var(--royal-blue-deep);
        margin-bottom: 6px;
    }

    .panel span { color: var(--muted); font-weight: 600; }

    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 20px;
        margin: 26px 0 18px;
    }

    .section-head h2 {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2rem, 4vw, 3rem);
        letter-spacing: -0.04em;
        color: var(--royal-blue-deep);
    }

    .section-head p {
        margin: 10px 0 0;
        color: var(--muted);
        max-width: 680px;
    }

    .jobs-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .job-card {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        align-items: stretch;
    }

    .job-main {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        min-width: 0;
    }

    .job-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        flex-shrink: 0;
    }

    .job-title {
        margin: 0 0 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 1.18rem;
        color: var(--royal-blue-deep);
    }

    .company {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--royal-blue-bright);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .job-meta span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 11px;
        border-radius: 999px;
        background: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .job-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: space-between;
        padding-top: 8px;
        border-top: 1px solid rgba(16, 42, 114, 0.10);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(219, 234, 254, 0.9);
        color: var(--royal-blue-main);
        font-weight: 700;
        font-size: 0.9rem;
    }

    @media (max-width: 980px) {
        .hero,
        .jobs-list { grid-template-columns: 1fr; }
        .filters-row { grid-template-columns: 1fr; }
        .section-head { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="jobs-wrap">
    <div class="hero">
        <section class="hero-card">
            <div class="eyebrow"><i class="bi bi-person-check-fill"></i> Applicant jobs</div>
            <h1>Find jobs that fit your profile.</h1>
            <p>
                This is the applicant-specific jobs page. It is designed for browsing, filtering, and applying, while the public jobs page stays separate for visitors.
            </p>

            <form class="filters" action="{{ route('jobs.applicant') }}" method="GET">
                <input type="text" name="q" placeholder="Search by role or company">
                <div class="filters-row">
                    <select name="location">
                        <option>All locations</option>
                        <option>Remote</option>
                        <option>Manila</option>
                        <option>Cebu</option>
                    </select>
                    <select name="type">
                        <option>All job types</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Contract</option>
                    </select>
                </div>
                <button class="button button-primary" type="submit">Search Applicant Jobs</button>
            </form>
        </section>

        <aside class="panel-card">
            <h2 style="margin:0;font-family:'Poppins',sans-serif;color:var(--royal-blue-deep);font-size:1.65rem;">Your snapshot</h2>
            <p style="margin:8px 0 0;color:var(--muted);">A dashboard view for active applicants.</p>
            <div class="panel-grid" style="margin-top:18px;">
                <div class="panel"><strong>6</strong><span>saved jobs</span></div>
                <div class="panel"><strong>4</strong><span>new matches</span></div>
                <div class="panel"><strong>2</strong><span>pending apps</span></div>
                <div class="panel"><strong>1</strong><span>interview</span></div>
            </div>
            <div style="margin-top:18px; display:flex; gap:12px; flex-wrap:wrap;">
                <a class="button button-ghost" style="color:var(--royal-blue-deep);border-color:rgba(16,42,114,.14);background:#fff;" href="{{ route('profile.show') }}">Profile</a>
                <a class="button button-ghost" style="color:var(--royal-blue-deep);border-color:rgba(16,42,114,.14);background:#fff;" href="{{ route('notifications.index') }}">Notifications</a>
            </div>
        </aside>
    </div>

    <div class="section-head">
        <div>
            <h2>Applicant job feed</h2>
            <p>These listings are presented in a dashboard grid with apply-focused actions, unlike the public browsing page.</p>
        </div>
    </div>

    <div class="jobs-list">
        <article class="job-card">
            <div class="job-main">
                <div class="job-icon"><i class="bi bi-code-slash"></i></div>
                <div>
                    <h3 class="job-title">Frontend Developer</h3>
                    <div class="company"><i class="bi bi-building"></i> Nova Studio</div>
                    <p style="margin:0;color:var(--muted);">Built for applicants who want quick actions, profile matching, and a direct apply flow.</p>
                    <div class="job-meta">
                        <span><i class="bi bi-geo-alt-fill"></i> Remote</span>
                        <span><i class="bi bi-briefcase-fill"></i> Full-time</span>
                        <span><i class="bi bi-shield-check"></i> Match score 92%</span>
                    </div>
                </div>
            </div>
            <div class="job-actions">
                <span class="badge"><i class="bi bi-check2-circle"></i> Recommended</span>
                <a class="button button-primary" href="{{ route('jobs.show', 1) }}">View & Apply</a>
            </div>
        </article>

        <article class="job-card">
            <div class="job-main">
                <div class="job-icon"><i class="bi bi-pencil-square"></i></div>
                <div>
                    <h3 class="job-title">UI/UX Designer</h3>
                    <div class="company"><i class="bi bi-building"></i> Creative Studio</div>
                    <p style="margin:0;color:var(--muted);">Focused on saved searches, alerts, and application tracking for logged-in users.</p>
                    <div class="job-meta">
                        <span><i class="bi bi-geo-alt-fill"></i> Manila</span>
                        <span><i class="bi bi-briefcase-fill"></i> Contract</span>
                        <span><i class="bi bi-bell-fill"></i> New alert</span>
                    </div>
                </div>
            </div>
            <div class="job-actions">
                <span class="badge"><i class="bi bi-bookmark-check-fill"></i> Saved</span>
                <a class="button button-primary" href="{{ route('jobs.show', 2) }}">View & Apply</a>
            </div>
        </article>
    </div>
</div>
@endsection
