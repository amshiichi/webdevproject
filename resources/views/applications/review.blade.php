<!--
The detail view for an employer to look at a specific applicant's resume and change their status via a dropdown.
-->
<!-- Employer view to evaluate an applicant's resume and update their status. -->
@extends('layouts.app')

@section('content')
<style>
    .rv-wrap{max-width:960px;margin:32px auto;padding:0 16px;font-family:'Inter',sans-serif;color:var(--ink)}
    .rv-head{font-family:'Poppins',sans-serif;font-weight:700;font-size:26px;color:var(--rb-900);margin:0 0 6px}
    .rv-sub{color:var(--muted);font-size:14px;margin-bottom:22px}
    .rv-grid{display:grid;grid-template-columns:1fr 320px;gap:20px}
    @media(max-width:820px){.rv-grid{grid-template-columns:1fr}}
    .card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:24px;box-shadow:0 1px 2px rgba(15,23,42,.04)}
    .applicant{display:flex;align-items:center;gap:14px;margin-bottom:18px}
    .avatar{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--rb-600),var(--rb-500));color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:20px}
    .applicant h2{font-family:'Poppins',sans-serif;font-weight:600;font-size:18px;margin:0;color:var(--rb-900)}
    .applicant .role{color:var(--muted);font-size:13px}
    .meta-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:14px 0 18px}
    .meta-row .item{background:var(--rb-50);padding:10px 14px;border-radius:10px}
    .meta-row .lbl{font-size:12px;color:var(--rb-700);font-weight:600;text-transform:uppercase;letter-spacing:.5px}
    .meta-row .val{font-size:14px;color:var(--ink);margin-top:2px}
    h3.section{font-family:'Poppins',sans-serif;font-weight:600;font-size:15px;color:var(--rb-900);margin:18px 0 8px}
    .cover{font-size:14px;line-height:1.65;color:#334155}
    .resume-box{display:flex;align-items:center;justify-content:space-between;background:var(--rb-50);border:1px solid var(--line);border-radius:10px;padding:12px 14px;margin-top:8px}
    .resume-box .name{font-size:14px;font-weight:500;color:var(--rb-700)}
    .btn{padding:9px 16px;font-size:13px;font-weight:600;border-radius:8px;cursor:pointer;border:none;font-family:'Inter',sans-serif;transition:.15s;text-decoration:none;display:inline-block}
    .btn-primary{background:var(--rb-600);color:#fff}
    .btn-primary:hover{background:var(--rb-700)}
    .btn-ghost{background:#fff;color:var(--rb-700);border:1px solid var(--line)}

    .side h3{font-family:'Poppins',sans-serif;font-weight:600;font-size:16px;color:var(--rb-900);margin:0 0 12px}
    .field{margin-bottom:14px}
    .field label{display:block;font-size:13px;font-weight:600;color:var(--rb-900);margin-bottom:6px}
    .field select,.field textarea{width:100%;padding:10px 12px;font-size:14px;font-family:'Inter',sans-serif;border:1px solid var(--line);border-radius:10px;background:#fff;box-sizing:border-box}
    .field textarea{min-height:90px;resize:vertical}
    .pill{display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600}
    .pill-pending{background:#fff7ed;color:var(--warn)}
    .pill-accepted{background:#ecfdf5;color:var(--ok)}
    .pill-rejected{background:#fef2f2;color:var(--bad)}
</style>

<div class="rv-wrap">
    <h1 class="rv-head">Application Review</h1>
    <div class="rv-sub">Evaluate this candidate and update their application status.</div>

    <div class="rv-grid">
        <div class="card">
            <div class="applicant">
                <div class="avatar">{{ strtoupper(substr($application->user->name ?? 'A',0,1)) }}</div>
                <div>
                    <h2>{{ $application->user->name ?? 'Applicant Name' }}</h2>
                    <div class="role">Applied for: {{ $application->job->title ?? 'Job Title' }}</div>
                </div>
                <div style="margin-left:auto">
                    <span class="pill pill-{{ $application->status ?? 'pending' }}">{{ ucfirst($application->status ?? 'pending') }}</span>
                </div>
            </div>

            <div class="meta-row">
                <div class="item"><div class="lbl">Email</div><div class="val">{{ $application->user->email ?? 'email@example.com' }}</div></div>
                <div class="item"><div class="lbl">Applied On</div><div class="val">{{ $application->created_at ?? 'Jun 21, 2026' }}</div></div>
            </div>

            <h3 class="section">Cover Letter</h3>
            <p class="cover">{{ $application->cover_letter ?? 'Placeholder cover letter text from the applicant.' }}</p>

            <h3 class="section">Resume</h3>
            <div class="resume-box">
                <span class="name">📄 {{ $application->resume_filename ?? 'resume.pdf' }}</span>
                <a href="{{ $application->resume_url ?? '#' }}" target="_blank" class="btn btn-ghost">View PDF</a>
            </div>
        </div>

        <aside class="card side">
            <h3>Update Status</h3>
            <form method="POST" action="{{ route('applications.updateStatus', $application->id ?? 1) }}">
                @csrf
                @method('PUT')
                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="field">
                    <label>Notes (optional)</label>
                    <textarea name="notes" placeholder="Internal notes about this applicant..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Save Decision</button>
            </form>
        </aside>
    </div>
</div>
@endsection
