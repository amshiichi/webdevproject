@extends('layouts.app')
@section('title', 'Employer Applications')
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

    .track-wrap {
        max-width: 1360px;
        margin: 0 auto;
        padding: 56px 32px 100px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 24px;
        margin-bottom: 26px;
    }

    .hero-card,
    .panel-card,
    .table-card,
    .stat-card {
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
        font-size: clamp(2.6rem, 5vw, 4.4rem);
        line-height: 0.96;
        letter-spacing: -0.05em;
        color: #fff;
        max-width: 12ch;
    }

    .hero-card p {
        margin: 0;
        max-width: 720px;
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.84);
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

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 26px;
        position: relative;
        z-index: 1;
    }

    .panel-card {
        padding: 28px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .stat-card {
        padding: 18px;
        background: var(--royal-blue-light);
    }

    .stat-card strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 1.9rem;
        color: var(--royal-blue-deep);
        margin-bottom: 6px;
    }

    .stat-card span { color: var(--muted); font-weight: 600; }

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
        max-width: 720px;
    }

    .table-card {
        overflow: hidden;
    }

    .tracking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tracking-table th {
        background: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        text-align: left;
        padding: 20px 24px;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .tracking-table td {
        padding: 22px 24px;
        border-top: 1px solid rgba(16, 42, 114, 0.08);
        color: var(--royal-blue-deep);
        vertical-align: middle;
    }

    .job-name {
        font-family: 'Poppins', sans-serif;
        font-size: 1.08rem;
        margin: 0 0 4px;
        color: var(--royal-blue-deep);
    }

    .company {
        color: var(--royal-blue-main);
        font-weight: 700;
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
        font-size: 0.9rem;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--royal-blue-bright);
        font-weight: 700;
        text-decoration: none;
    }

    .action-link:hover { text-decoration: underline; }

    @media (max-width: 980px) {
        .hero { grid-template-columns: 1fr; }
        .section-head { flex-direction: column; align-items: stretch; }
        .tracking-table { display: block; overflow-x: auto; }
    }
</style>

<div class="track-wrap">
    <div class="hero">
        <section class="hero-card">
            <div class="eyebrow"><i class="bi bi-inboxes-fill"></i> Job posting tracking</div>
            <h1>Track your job posts and applicants.</h1>
            <p>
                This employer view shows each job post, how many applications it received, and where it stands in the hiring process.
            </p>
            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('jobs.create') }}"><i class="bi bi-plus-circle-fill"></i> Post a Job</a>
                <a class="button button-ghost" href="{{ route('employer.home') }}"><i class="bi bi-house-fill"></i> Back to Home</a>
            </div>
        </section>

        <aside class="panel-card">
            <div class="stats-grid">
                <div class="stat-card"><strong>14</strong><span>jobs posted</span></div>
                <div class="stat-card"><strong>36</strong><span>applications</span></div>
                <div class="stat-card"><strong>8</strong><span>shortlisted</span></div>
                <div class="stat-card"><strong>3</strong><span>filled roles</span></div>
            </div>
        </aside>
    </div>

    <div class="section-head">
        <div>
            <h2>Posting status</h2>
            <p>Use this page to see the performance of every job post and open the application review flow.</p>
        </div>
    </div>

    <div class="table-card">
        <table class="tracking-table">
            <thead>
                <tr>
                    <th>Job Post</th>
                    <th>Company</th>
                    <th>Applications</th>
                    <th>Shortlisted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p class="job-name">Frontend Developer</p>
                        <div style="color:var(--muted);">Posted Jun 10, 2026</div>
                    </td>
                    <td class="company">TechCorp</td>
                    <td>18</td>
                    <td>5</td>
                    <td><span class="status-pill"><i class="bi bi-lightning-charge-fill"></i> Live</span></td>
                    <td><a class="action-link" href="{{ route('applications.review', 1) }}">View</a></td>
                </tr>
                <tr>
                    <td>
                        <p class="job-name">UI/UX Designer</p>
                        <div style="color:var(--muted);">Posted Jun 05, 2026</div>
                    </td>
                    <td class="company">Creative Studio</td>
                    <td>12</td>
                    <td>4</td>
                    <td><span class="status-pill"><i class="bi bi-clock-history"></i> Screening</span></td>
                    <td><a class="action-link" href="{{ route('applications.review', 2) }}">View</a></td>
                </tr>
                <tr>
                    <td>
                        <p class="job-name">Project Coordinator</p>
                        <div style="color:var(--muted);">Posted May 29, 2026</div>
                    </td>
                    <td class="company">Northwave Ltd.</td>
                    <td>9</td>
                    <td>2</td>
                    <td><span class="status-pill"><i class="bi bi-check2-circle"></i> Closed</span></td>
                    <td><a class="action-link" href="{{ route('applications.review', 3) }}">View</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
