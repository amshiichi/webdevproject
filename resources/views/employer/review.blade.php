@extends('layouts.app')
@section('content')
<style>
    .rv-wrap{max-width:1240px;margin:42px auto 100px;padding:0 24px;font-family:'Inter',sans-serif;color:var(--ink)}
    .rv-head{font-family:'Poppins',sans-serif;font-weight:700;font-size:30px;color:var(--rb-900);margin:0 0 8px}
    .rv-sub{color:var(--muted);font-size:15px;margin-bottom:24px}
    .rv-grid{display:grid;grid-template-columns:1fr 340px;gap:20px}
    @media(max-width:900px){.rv-grid{grid-template-columns:1fr}}
    .card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:24px;box-shadow:0 1px 2px rgba(15,23,42,.04)}
    .job-top{display:flex;justify-content:space-between;gap:16px;align-items:flex-start;margin-bottom:18px}
    .job-top h2{font-family:'Poppins',sans-serif;font-weight:700;font-size:24px;margin:0;color:var(--rb-900)}
    .job-top .meta{color:var(--muted);font-size:14px;margin-top:4px}
    .summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin:18px 0 24px}
    .summary .item{background:var(--rb-50);padding:14px;border-radius:14px}
    .summary .lbl{font-size:12px;color:var(--rb-700);font-weight:700;text-transform:uppercase;letter-spacing:.5px}
    .summary .val{font-size:22px;font-family:'Poppins',sans-serif;color:var(--rb-900);margin-top:4px}
    .section-title{font-family:'Poppins',sans-serif;font-weight:600;font-size:16px;color:var(--rb-900);margin:0 0 12px}
    .app-list{display:grid;gap:12px}
    .applicant-row{display:flex;justify-content:space-between;gap:16px;align-items:center;padding:16px;border:1px solid var(--line);border-radius:14px;background:#fff;text-decoration:none;transition:.15s}
    .applicant-row:hover{border-color:var(--rb-500);box-shadow:0 8px 20px rgba(59,130,246,.08);transform:translateY(-1px)}
    .applicant-main{display:flex;align-items:center;gap:14px}
    .avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,var(--rb-600),var(--rb-500));color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:18px;flex-shrink:0}
    .applicant-name{font-family:'Poppins',sans-serif;font-weight:600;font-size:16px;margin:0;color:var(--rb-900)}
    .applicant-link{color:inherit;text-decoration:none}
    .applicant-link:hover{text-decoration:underline}
    .applicant-meta{color:var(--muted);font-size:13px;margin-top:4px}
    .field{margin-bottom:14px}
    .field label{display:block;font-size:13px;font-weight:600;color:var(--rb-900);margin-bottom:6px}
    .field select,.field textarea{width:100%;padding:10px 12px;font-size:14px;font-family:'Inter',sans-serif;border:1px solid var(--line);border-radius:10px;background:#fff;box-sizing:border-box}
    .field textarea{min-height:110px;resize:vertical}
    .btn{padding:10px 16px;font-size:13px;font-weight:700;border-radius:10px;cursor:pointer;border:none;font-family:'Inter',sans-serif;transition:.15s;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
    .btn-primary{background:var(--rb-600);color:#fff}
    .btn-primary:hover{background:var(--rb-700)}
    .btn-ghost{background:#fff;color:var(--rb-700);border:1px solid var(--line)}
    .note{font-size:14px;color:var(--muted);line-height:1.65}
</style>

<div class="rv-wrap">
    <h1 class="rv-head">Job Applicant Tracking</h1>
    <div class="rv-sub">View the applicants for this job and update the job posting status.</div>

    <div class="rv-grid">
        <div class="card">
            <div class="job-top">
                <div>
                    <h2>{{ $job->title }}</h2>
                    <div class="meta">{{ $job->company }} • Posted {{ $job->posted_at }}</div>
                </div>
            </div>

            <div class="summary">
                <div class="item">
                    <div class="lbl">Applications</div>
                    <div class="val">{{ $job->applications_count }}</div>
                </div>
                <div class="item">
                    <div class="lbl">Shortlisted</div>
                    <div class="val">{{ $shortlistedCount }}</div>
                </div>
                <div class="item">
                    <div class="lbl">Status</div>
                    <div class="val">{{ ucfirst($job->posting_status) }}</div>
                </div>
            </div>

            <h3 class="section-title">Applicants</h3>
            <div class="app-list">
                @forelse ($applications as $application)
                    <a class="applicant-row" href="{{ route('applications.applicant', ['jobId' => $job->id, 'applicantId' => $application->applicant->id]) }}">
                        <div class="applicant-main">
                            <div class="avatar">{{ strtoupper(substr($application->applicant->name, 0, 1)) }}</div>
                            <div>
                                <div class="applicant-name"><span class="applicant-link">{{ $application->applicant->name }}</span></div>
                                <div class="applicant-meta">{{ $application->applicant->email }} • Status: {{ ucfirst($application->status) }}</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>No applicants yet.</p>
                @endforelse
            </div>
        </div>

        <aside class="card side">
            <h3 class="section-title">Posting Status</h3>
            <p class="note">Change the posting status to Live, Screening, or Closed.</p>
            <form method="POST" action="{{ route('applications.updateStatus', $job->id) }}">
                @csrf
                <div class="field">
                    <label>Posting Status</label>
                    <select name="status">
                        <option value="live" {{ $job->status === 'live' ? 'selected' : '' }}>Live</option>
                        <option value="screening" {{ $job->status === 'screening' ? 'selected' : '' }}>Screening</option>
                        <option value="closed" {{ $job->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Save Status</button>
            </form>

            <div style="margin-top:16px; display:grid; gap:10px;">
                <a class="btn btn-ghost" href="{{ route('jobs.edit', $job->id) }}">Edit Job Post</a>
                <a class="btn btn-ghost" href="{{ route('applications.index') }}">Back to Tracking</a>
            </div>
        </aside>
    </div>

</div>
@endsection
