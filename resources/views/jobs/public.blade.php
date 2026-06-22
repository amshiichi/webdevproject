@extends('layouts.app')
@section('title', 'Public Jobs')
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
        max-width: 1480px;
        margin: 0 auto;
        padding: 56px 32px 100px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        display: grid;
        grid-template-columns: 1fr;
        gap: 28px;
        align-items: stretch;
        margin-bottom: 28px;
    }

    .hero-card,
    .side-card,
    .section-card,
    .job-card {
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
        width: 100%;
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
        color: #fff;
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

    .hero-search {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .hero-search input {
        flex: 1 1 280px;
        min-width: 0;
        padding: 15px 18px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font: inherit;
        outline: none;
    }

    .hero-search select {
        color: var(--ink);
        background: rgba(255, 255, 255, 0.92);
        border-radius: 999px;
        padding: 12px 16px;
        border: 1px solid rgba(255,255,255,0.12);
        font: inherit;
    }

    .hero-search input::placeholder {
        color: rgba(255, 255, 255, 0.72);
    }

    .hero-search input:focus {
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.12);
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

    .search-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-bar input {
        min-width: 240px;
        padding: 14px 18px;
        border-radius: 999px;
        border: 1px solid var(--royal-blue-tint);
        font: inherit;
        outline: none;
    }

    .search-bar input:focus {
        border-color: var(--royal-blue-bright);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }

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

    .footer { padding: 24px 0 40px; color: var(--muted); font-size: 0.95rem; }

    @media (max-width: 980px) {
        .hero,
        .grid-2 { grid-template-columns: 1fr; }
        .section-head { flex-direction: column; align-items: stretch; }
        .search-bar { width: 100%; }
        .search-bar input { width: 100%; min-width: 0; }
    }
</style>

<div class="jobs-wrap">
    <div class="hero">
        <section class="hero-card">
            <div class="eyebrow"><i class="bi bi-stars"></i> Public jobs board</div>
            <h1>Ready to find a job?</h1>
            <p>
                Search through live listings now, then open a role or create an account when you want to apply.
            </p>

            <form action="{{ route('jobs.public') }}" method="GET" class="hero-search">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search job title, company, or location">
                <button class="button button-primary" type="submit">Search Jobs</button>
            </form>

            <div class="hero-actions">
                <a class="button button-primary" href="#jobs"><i class="bi bi-arrow-down-circle"></i> Browse Listings</a>
                <a class="button button-ghost" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Create Account</a>
            </div>
        </section>

    </div>

    <section class="section" id="jobs">
        <div class="section-head">
            <div>
                <h2>Available Jobs</h2>
                <p>Browse roles now and use the search bar above to narrow down the best fit before opening the full job details.</p>
            </div>
        </div>

        <div class="grid-2">
            @forelse($jobs as $job)
            <article class="job-card">
                <div class="job-top">
                    <div>
                        <h3 style="margin:0 0 10px;font-family:'Poppins',sans-serif;font-size:1.35rem;color:var(--royal-blue-deep);">{{ $job->title }}</h3>
                        <div class="company"><i class="bi bi-building"></i> {{ $job->company }}</div>
                    </div>
                    <div class="ghost-icon"><i class="bi bi-bookmark"></i></div>
                </div>
                <div class="meta">
                    <span><i class="bi bi-geo-alt-fill"></i> {{ $job->location }}</span>
                    <span><i class="bi bi-briefcase-fill"></i> {{ ucfirst($job->type) }}</span>
                    @if($job->salary_min && $job->salary_max)
                    <span><i class="bi bi-cash-stack"></i> ₱{{ number_format($job->salary_min) }} - ₱{{ number_format($job->salary_max) }}</span>
                    @endif
                </div>
                <p style="margin:0;color:var(--muted);line-height:1.7;">{{ Str::limit($job->description, 120) }}</p>
                <div class="job-actions">
                    @if(Auth::check())
                    <small style="color:var(--royal-blue-bright);font-weight:700;"><i class="bi bi-check-circle-fill"></i> Authenticated</small>
                    <a class="button button-primary" href="{{ route('jobs.show', $job->id) }}">View Job</a>
                    @else
                    <small style="color:var(--royal-blue-bright);font-weight:700;"><i class="bi bi-lock-fill"></i> Login required to apply</small>
                    <a class="button button-primary" href="{{ route('login') }}">Login to Apply</a>
                    @endif
                </div>
            </article>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                <p style="color: var(--muted); font-size: 1.1rem;">No jobs available at the moment. Please try again later.</p>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
