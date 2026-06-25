@extends('layouts.app')
@section('title', 'Find Jobs')
@section('content')
<style>
    :root {
        --royal-blue-deep: #0f1e46;
        --royal-blue-main: #1e40af;
        --royal-blue-bright: #2563eb;
        --royal-blue-light: #eff6ff;
        --royal-blue-tint: #dbeafe;
        --pure-white: #ffffff;
    }

    .job-board-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--royal-blue-bright), var(--royal-blue-deep));
        color: var(--pure-white);
        padding: 120px 32px;
        text-align: center;
        border-radius: 0 0 40px 40px;
        box-shadow: 0 20px 40px rgba(30, 64, 175, 0.15);
    }

    .hero-title {
        font-size: 64px;
        font-weight: 800;
        margin-bottom: 20px;
        color: var(--pure-white);
        letter-spacing: -1px;
    }

    .hero-subtitle {
        color: var(--royal-blue-tint);
        font-size: 22px;
        margin-bottom: 44px;
        font-weight: 400;
    }

    .search-container {
        max-width: 850px;
        margin: auto;
        background: var(--pure-white);
        border-radius: 100px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 15px 35px rgba(15, 30, 70, 0.2);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .search-container:focus-within {
        border-color: var(--royal-blue-tint);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.25);
    }

    .search-icon {
        font-size: 24px;
        color: var(--royal-blue-main);
        margin-left: 20px;
    }

    .search-input {
        border: none;
        flex: 1;
        outline: none;
        font-size: 18px;
        color: var(--royal-blue-deep);
    }

    .search-input::placeholder {
        color: #93c5fd;
    }

    .main-layout {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 48px;
        margin-top: 60px;
        margin-bottom: 80px;
    }

    .sidebar-filters {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        padding: 36px;
        height: fit-content;
        border-radius: 24px;
        position: sticky;
        top: 40px;
        box-shadow: 0 10px 25px rgba(30, 64, 175, 0.03);
    }

    .filter-heading {
        font-size: 24px;
        font-weight: 700;
        color: var(--royal-blue-deep);
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-group {
        margin-bottom: 28px;
    }

    .filter-label {
        font-weight: 600;
        font-size: 18px;
        color: var(--royal-blue-deep);
        display: block;
        margin-bottom: 12px;
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 14px 18px;
        font-size: 18px;
        border-radius: 12px;
        border: 2px solid var(--royal-blue-light);
        background-color: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        outline: none;
        transition: all 0.3s ease;
    }

    .filter-select:focus, .filter-input:focus {
        border-color: var(--royal-blue-bright);
        background-color: var(--pure-white);
    }

    .job-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        padding: 38px;
        margin-bottom: 28px;
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.02);
    }

    .job-card:hover {
        transform: translateY(-4px);
        border-color: var(--royal-blue-tint);
        box-shadow: 0 16px 30px rgba(30, 64, 175, 0.07);
    }

    .job-title {
        font-size: 28px;
        margin-bottom: 12px;
        font-weight: 700;
        color: var(--royal-blue-deep);
    }

    .company-name {
        color: var(--royal-blue-main);
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .meta-tag-container {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        color: var(--royal-blue-main);
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 24px;
    }

    .meta-tag {
        display: flex;
        align-items: center;
        background: var(--royal-blue-light);
        padding: 6px 14px;
        border-radius: 8px;
        gap: 8px;
    }

    .job-description {
        color: var(--royal-blue-deep);
        opacity: 0.85;
        font-size: 18px;
        line-height: 1.6;
    }

    .btn-royal-primary {
        background: var(--royal-blue-bright);
        color: var(--pure-white);
        font-weight: 600;
        font-size: 18px;
        padding: 14px 32px;
        border-radius: 12px;
        border: none;
        transition: all 0.2s ease;
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
        font-size: 18px;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .btn-royal-outline:hover {
        background: var(--royal-blue-light);
        color: var(--royal-blue-main);
    }

    .btn-search-submit {
        background: var(--royal-blue-bright);
        color: var(--pure-white);
        font-weight: 600;
        font-size: 18px;
        padding: 14px 38px;
        border-radius: 50px;
        border: none;
    }

    .btn-search-submit:hover {
        background: var(--royal-blue-main);
    }

    .section-header-title {
        font-size: 38px;
        font-weight: 800;
        color: var(--royal-blue-deep);
    }

    .section-header-subtitle {
        color: var(--royal-blue-main);
        font-size: 18px;
        font-weight: 500;
    }

    .custom-hr {
        border: 0;
        border-top: 2px solid var(--royal-blue-light);
        margin: 28px 0;
    }
</style>

<section class="hero-section">
    <div style="max-width:1000px; margin:auto">
        <h1 class="hero-title">Find Your Dream Job</h1>
        <p class="hero-subtitle">Discover opportunities from top companies and start your next career journey.</p>

        <form action="{{ route('jobs.index') }}" method="GET" class="search-container">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="keyword" placeholder="Search jobs, companies, skills..." class="search-input" value="{{ request('keyword') }}">
            <button class="btn btn-royal-primary btn-search-submit" type="submit">
                Search
            </button>
        </form>
    </div>
</section>

<div class="job-board-wrapper">
    <div class="main-layout">

        <aside class="sidebar-filters">
            <h3 class="filter-heading">
                <i class="bi bi-funnel-fill"></i>
                Filters
            </h3>

            <form method="GET" action="{{ route('jobs.index') }}">
                <div class="filter-group">
                    <label class="filter-label">Job Type</label>
                    <select name="type" class="filter-select">
                        <option value="">All Jobs</option>
                        <option value="full-time" @selected(request('type') == 'full-time')>Full-time</option>
                        <option value="part-time" @selected(request('type') == 'part-time')>Part-time</option>
                        <option value="contract" @selected(request('type') == 'contract')>Contractual</option>
                        <option value="internship" @selected(request('type') == 'internship')>Internship</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Location</label>
                    <input type="text" name="location" placeholder="City or Remote" class="filter-input" value="{{ request('location') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Experience Level</label>
                    <select name="experience_level" class="filter-select">
                        <option value="">Any</option>
                        <option value="entry" @selected(request('experience_level') == 'entry')>Entry Level</option>
                        <option value="mid" @selected(request('experience_level') == 'mid')>Mid Level</option>
                        <option value="senior" @selected(request('experience_level') == 'senior')>Senior Level</option>
                    </select>
                </div>

                <button class="btn btn-royal-primary" style="width:100%; margin-top: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Apply Filters
                </button>
            </form>
        </aside>

        <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:36px;">
                <div>
                    <h2 class="section-header-title">Available Jobs</h2>
                    <p class="section-header-subtitle">{{ $jobs->count() }} opportunities listed</p>
                </div>

                @if(auth()->check() && auth()->user()->role === 'employer')
                    <a href="{{ route('jobs.create') }}" class="btn btn-royal-primary d-inline-flex align-items-center">
                        <i class="bi bi-plus-circle-fill me-2"></i> Post Job
                    </a>
                @endif
            </div>

            @forelse ($jobs as $job)
                <div class="job-card">
                    <div style="display:flex; justify-content:space-between; align-items:start; gap:24px;">
                        <div>
                            <h3 class="job-title">{{ $job->title }}</h3>
                            <p class="company-name">
                                <i class="bi bi-building me-2"></i> {{ $job->company }}
                            </p>

                            <div class="meta-tag-container">
                                <span class="meta-tag">
                                    <i class="bi bi-geo-alt-fill me-2"></i> {{ $job->location }}
                                </span>
                                <span class="meta-tag">
                                    <i class="bi bi-briefcase-fill me-2"></i> {{ ucfirst(str_replace('-', ' ', $job->type)) }}
                                </span>
                                <span class="meta-tag">
                                    <i class="bi bi-bar-chart-fill me-2"></i> {{ ucfirst($job->experience_level) }} Level
                                </span>
                                <span class="meta-tag">
                                    <i class="bi bi-cash-stack me-2"></i>
                                    @if ($job->salary_min && $job->salary_max)
                                        ₱{{ number_format($job->salary_min) }} – ₱{{ number_format($job->salary_max) }}
                                    @else
                                        Competitive
                                    @endif
                                </span>
                            </div>

                            <p class="job-description">
                                {{ Str::limit($job->description, 150) }}
                            </p>
                        </div>
                    </div>

                    <hr class="custom-hr">

                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <small style="color:var(--royal-blue-main); font-weight: 500; font-size: 18px;">
                            <i class="bi bi-clock-history me-2"></i> Posted {{ $job->created_at->diffForHumans() }}
                        </small>
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-royal-primary">View Job</a>
                    </div>
                </div>
            @empty
                <div class="job-card" style="text-align:center;">
                    <p class="job-description">No jobs found matching your search.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection