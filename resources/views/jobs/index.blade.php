<!--
The Homepage. Contains the search input, filter sidebar, and the list of jobs.
-->

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

    /* Layout ng Structure */
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

{{-- HERO SECTION --}}
<section class="hero-section">
    <div style="max-width:1000px; margin:auto">
        <h1 class="hero-title">Find Your Dream Job</h1>
        <p class="hero-subtitle">Discover opportunities from top companies and start your next career journey.</p>

        <form action="{{ route('jobs.index') }}" method="GET" class="search-container">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="q" placeholder="Search jobs, companies, skills..." class="search-input">
            <button class="btn btn-royal-primary btn-search-submit" type="submit">
                Search
            </button>
        </form>
    </div>
</section>

{{-- MAIN CONTENT --}}
<div class="job-board-wrapper">
    <div class="main-layout">

        {{-- FILTERS --}}
        <aside class="sidebar-filters">
            <h3 class="filter-heading">
                <i class="bi bi-funnel-fill"></i>
                Filters
            </h3>

            <form method="GET">
                <div class="filter-group">
                    <label class="filter-label">Job Type</label>
                    <select name="type" class="filter-select">
                        <option value="">All Jobs</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Contract</option>
                        <option>Internship</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Location</label>
                    <input type="text" name="location" placeholder="City or Remote" class="filter-input">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Experience Level</label>
                    <select class="filter-select">
                        <option>Any</option>
                        <option>Entry Level</option>
                        <option>Mid Level</option>
                        <option>Senior</option>
                    </select>
                </div>

                <button class="btn btn-royal-primary" style="width:100%; margin-top: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Apply Filters
                </button>
            </form>
        </aside>

        {{-- JOB LIST --}}
        <div>
            {{-- HEADER --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:36px;">
                <div>
                    <h2 class="section-header-title">Available Jobs</h2>
                    <p class="section-header-subtitle">250+ opportunities listed</p>
                </div>

                <a href="{{ route('jobs.create') ?? '#' }}" class="btn btn-royal-primary d-inline-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Post Job
                </a>
            </div>

            {{-- JOB CARD 1 --}}
            <div class="job-card">
                <div style="display:flex; justify-content:space-between; align-items:start; gap:24px;">
                    <div>
                        <h3 class="job-title">Software Engineer</h3>
                        <p class="company-name">
                            <i class="bi bi-building me-2"></i> TechCorp Inc.
                        </p>

                        <div class="meta-tag-container">
                            <span class="meta-tag">
                                <i class="bi bi-geo-alt-fill me-2"></i> Manila
                            </span>
                            <span class="meta-tag">
                                <i class="bi bi-briefcase-fill me-2"></i> Full-time
                            </span>
                            <span class="meta-tag">
                                <i class="bi bi-cash-stack me-2"></i> ₱45,000 - ₱60,000
                            </span>
                        </div>

                        <p class="job-description">
                            Build and maintain scalable web applications using modern technologies and collaborate with cross-functional teams.
                        </p>
                    </div>

                    <div>
                        <button class="btn btn-royal-outline" style="padding: 12px 16px;">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>
                </div>

                <hr class="custom-hr">

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small style="color:var(--royal-blue-main); font-weight: 500; font-size: 18px;">
                        <i class="bi bi-clock-history me-2"></i> Posted 2 days ago
                    </small>
                    <a href="#" class="btn btn-royal-primary">View Job</a>
                </div>
            </div>

            {{-- JOB CARD 2 --}}
            <div class="job-card">
                <div style="display:flex; justify-content:space-between; align-items:start; gap:24px;">
                    <div>
                        <h3 class="job-title">UI/UX Designer</h3>
                        <p class="company-name">
                            <i class="bi bi-building me-2"></i> Creative Studio
                        </p>

                        <div class="meta-tag-container">
                            <span class="meta-tag">
                                <i class="bi bi-geo-alt-fill me-2"></i> Remote
                            </span>
                            <span class="meta-tag">
                                <i class="bi bi-briefcase-fill me-2"></i> Full-time
                            </span>
                            <span class="meta-tag">
                                <i class="bi bi-cash-stack me-2"></i> ₱40,000 - ₱55,000
                            </span>
                        </div>

                        <p class="job-description">
                            Design intuitive user experiences and collaborate with developers to create modern digital products.
                        </p>
                    </div>
                    
                    <div>
                        <button class="btn btn-royal-outline" style="padding: 12px 16px;">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>
                </div>

                <hr class="custom-hr">

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small style="color:var(--royal-blue-main); font-weight: 500; font-size: 18px;">
                        <i class="bi bi-clock-history me-2"></i> Posted today
                    </small>
                    <a href="#" class="btn btn-royal-primary">View Job</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection