@extends('layouts.app')
@section('title', 'Applicant Home')
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

    .applicant-wrap {
        max-width: 1360px;
        margin: 0 auto;
        padding: 56px 32px 100px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
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
        font-size: clamp(2.8rem, 5vw, 4.8rem);
        line-height: 0.96;
        letter-spacing: -0.05em;
        max-width: 11ch;
        color: #ffffff;
    }

    .hero-card p {
        margin: 0;
        max-width: 760px;
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.84);
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
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

    .side-card {
        padding: 28px;
        display: grid;
        gap: 16px;
        align-content: start;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .stat {
        padding: 18px;
        border-radius: 22px;
        background: var(--royal-blue-light);
    }

    .stat strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 1.9rem;
        color: var(--royal-blue-deep);
        margin-bottom: 6px;
    }

    .stat span { color: var(--muted); font-weight: 600; }

    .section { padding: 20px 0 88px; }
    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 20px;
        margin-bottom: 24px;
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

    .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }

    .feature-card,
    .job-card,
    .mini-card {
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid rgba(16, 42, 114, 0.10);
        border-radius: 28px;
        box-shadow: 0 18px 44px rgba(16, 42, 114, 0.08);
    }

    .feature-card { padding: 24px; }
    .feature-icon {
        width: 52px; height: 52px; border-radius: 16px; display: grid; place-items: center;
        color: var(--white); background: linear-gradient(135deg, var(--royal-blue-bright), var(--royal-blue-deep));
        margin-bottom: 18px; font-size: 1.2rem;
    }

    .feature-card h3,
    .job-card h3,
    .mini-card h3 {
        margin: 0 0 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        color: var(--royal-blue-deep);
    }

    .feature-card p,
    .job-card p,
    .mini-card p { color: var(--muted); line-height: 1.7; margin: 0; }

    .job-card { padding: 24px; display: flex; flex-direction: column; gap: 18px; }
    .job-top { display: flex; justify-content: space-between; gap: 16px; align-items: start; }
    .company {
        display: flex; align-items: center; gap: 10px; color: var(--royal-blue-bright); font-weight: 700; margin-bottom: 14px;
    }
    .meta { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
    .meta span {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 999px;
        background: rgba(224, 242, 254, 0.9); color: var(--royal-blue-deep); font-weight: 600; font-size: 0.92rem;
    }

    .job-actions {
        display: flex; justify-content: space-between; align-items: center; gap: 16px; padding-top: 8px;
        border-top: 1px solid rgba(16, 42, 114, 0.10);
    }

    .ghost-icon {
        width: 44px; height: 44px; border-radius: 14px; border: 1px solid rgba(16, 42, 114, 0.12);
        background: rgba(255, 255, 255, 0.92); display: grid; place-items: center; color: var(--royal-blue-deep);
    }

    .button-light { background: var(--pure-white); color: var(--royal-blue-deep); }

    .mini-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-top: 22px;
    }

    .mini-card { padding: 22px; }

    .job-feed {
        margin-top: 24px;
        background: var(--pure-white);
        border: 1px solid rgba(16, 42, 114, 0.10);
        border-radius: 28px;
        box-shadow: 0 18px 44px rgba(16, 42, 114, 0.08);
        overflow: hidden;
    }

    .job-feed-head {
        padding: 24px 24px 18px;
        border-bottom: 1px solid rgba(16, 42, 114, 0.08);
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }

    .job-feed-head h3 {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-size: 1.35rem;
        color: var(--royal-blue-deep);
    }

    .job-feed-head p {
        margin: 6px 0 0;
        color: var(--muted);
    }

    .job-feed-list {
        display: grid;
    }

    .job-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        padding: 22px 24px;
        border-top: 1px solid rgba(16, 42, 114, 0.08);
        align-items: center;
    }

    .job-row:first-child {
        border-top: 0;
    }

    .job-row-main {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .job-row-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: var(--royal-blue-deep);
        background: var(--royal-blue-light);
        flex-shrink: 0;
    }

    .job-row-title {
        margin: 0 0 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 1.12rem;
        color: var(--royal-blue-deep);
    }

    .job-row-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .job-row-meta span {
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

    .job-row-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(219, 234, 254, 0.9);
        color: var(--royal-blue-main);
        font-weight: 700;
        font-size: 0.92rem;
    }

    .footer { padding: 24px 0 40px; color: var(--muted); font-size: 0.95rem; }

    @media (max-width: 980px) {
        .hero,
        .grid-2,
        .mini-grid { grid-template-columns: 1fr; }
        .section-head { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="applicant-wrap">
    <div class="hero">
        <section class="hero-card">
            <div class="eyebrow"><i class="bi bi-person-badge-fill"></i> Applicant dashboard</div>
            <h1>Find your next job</h1>
            <p>pick up where you left off, review saved roles, open notifications, and head into the public job board whenever you want to browse new openings.</p>

            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('jobs.applicant') }}"><i class="bi bi-search"></i> Browse Jobs</a>
                <a class="button button-ghost" href="{{ route('notifications.index') }}"><i class="bi bi-bell-fill"></i> Notifications</a>
                <a class="button button-ghost" href="{{ route('profile.edit') }}"><i class="bi bi-pencil-square"></i> Edit Profile</a>
            </div>
        </section>

        <aside class="side-card">
            <h2 style="margin:0;font-family:'Poppins',sans-serif;color:var(--royal-blue-deep);font-size:1.7rem;">At a glance</h2>
            <p style="margin:0;color:var(--muted);">A quick overview of your activity.</p>
            <div class="stats-grid">
                <div class="stat"><strong>{{ $jobs->count() }}</strong><span>available roles</span></div>
                <div class="stat"><strong>{{ $applicationsCount }}</strong><span>applications</span></div>
                <div class="stat"><strong>{{ $interviewCount }}</strong><span>interviews</span></div>
                <div class="stat"><strong>{{ $notificationCount }}</strong><span>alerts</span></div>
            </div>
        </aside>
    </div>

    <div class="section">
        <div class="job-feed">
            <div class="job-feed-head">
                <div>
                    <h3>Recommended for you</h3>
                    <p>A compact feed for the applicant dashboard, separate from the public jobs browser.</p>
                </div>
                <a class="button button-ghost" href="{{ route('jobs.public') }}"><i class="bi bi-arrow-right"></i> Open Public Jobs</a>
            </div>

            <div class="job-feed-list">
                @forelse($recommended as $job)
                <div class="job-row">
                    <div class="job-row-main">
                        <div class="job-row-icon">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div>
                            <h3 class="job-row-title">
                                {{ $job->title }}
                            </h3>
                            <div class="company">
                                <i class="bi bi-building"></i>
                                {{ $job->company }}
                            </div>
                            <p>
                                {{ Str::limit($job->description,120) }}
                            </p>
                            <div class="job-row-meta">
                                <span>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $job->location }}
                                </span>
                                <span>
                                    <i class="bi bi-briefcase-fill"></i>
                                    {{ ucfirst($job->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('jobs.show',$job->id) }}"class="button button-primary">View Job</a>
                </div>
                @empty
                <p>No jobs available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
