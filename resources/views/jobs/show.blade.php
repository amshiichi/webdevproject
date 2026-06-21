<!--
Detailed view of a single job with an "Apply Now" button.
-->
<!-- Detailed view of a single job with an "Apply Now" button. -->
@extends('layouts.app')

@section('content')
<style>
    .job-wrap{max-width:900px;margin:32px auto;padding:0 16px;font-family:'Inter',sans-serif;color:var(--ink)}
    .job-hero{background:linear-gradient(135deg,var(--rb-700),var(--rb-500));color:#fff;border-radius:16px;padding:28px 32px;margin-bottom:24px}
    .job-hero h1{font-family:'Poppins',sans-serif;font-weight:700;font-size:28px;margin:0 0 6px}
    .job-hero .meta{font-size:14px;opacity:.9}
    .job-card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:28px;box-shadow:0 1px 2px rgba(15,23,42,.04)}
    .job-card h2{font-family:'Poppins',sans-serif;font-weight:600;font-size:20px;color:var(--rb-900);margin:0 0 10px}
    .job-card p{font-size:15px;line-height:1.65;color:#334155}
    .pill{display:inline-block;background:var(--rb-50);color:var(--rb-700);padding:4px 12px;border-radius:999px;font-size:13px;font-weight:500;margin-right:6px}
    .apply-bar{margin-top:24px;display:flex;justify-content:flex-end}
    .btn-apply{background:var(--rb-600);color:#fff;border:none;padding:12px 28px;font-size:14px;font-weight:600;border-radius:10px;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
    .btn-apply:hover{background:var(--rb-700)}
</style>

<div class="job-wrap">
    <div class="job-hero">
        <h1>{{ $job->title ?? 'Job Title Placeholder' }}</h1>
        <div class="meta">{{ $job->company ?? 'Company Name' }} • {{ $job->location ?? 'Location' }}</div>
    </div>

    <div class="job-card">
        <div style="margin-bottom:16px">
            <span class="pill">{{ $job->type ?? 'Full-time' }}</span>
            <span class="pill">{{ $job->salary ?? 'Competitive' }}</span>
        </div>
        <h2>Job Description</h2>
        <p>{{ $job->description ?? 'Placeholder description for this job posting.' }}</p>

        <h2 style="margin-top:22px">Requirements</h2>
        <p>{{ $job->requirements ?? 'Placeholder requirements list.' }}</p>

        <form action="{{ route('applications.store', $job->id ?? 1) }}" method="POST" class="apply-bar">
            @csrf
            <button type="submit" class="btn-apply">Apply Now →</button>
        </form>
    </div>
</div>
@endsection
