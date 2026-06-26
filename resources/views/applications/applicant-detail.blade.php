@extends('layouts.app')
@section('content')
@php($profile = $applicant->applicantProfile)
<style>
    .ad-wrap{
        max-width:1100px;
        margin:42px auto 100px;
        padding:0 24px;
        font-family:'Inter',sans-serif;
        color:var(--ink)
    }

    .ad-back{
        display:inline-flex;
        align-items:center;
        gap:8px;
        color:var(--rb-700);
        text-decoration:none;
        font-weight:700;
        margin-bottom:18px
    }

    .ad-grid{
        display:grid;
        grid-template-columns:1.15fr .85fr;
        gap:20px
    }
    
    @media(max-width:900px){
        .ad-grid{
            grid-template-columns:1fr
        }
    }

    .card{
        background:#fff;
        border:1px solid var(--line);
        border-radius:18px;
        padding:24px;
        box-shadow:0 1px 2px rgba(15,23,42,.04)
    }

    .head{
        display:flex;
        justify-content:space-between;
        gap:16px;
        align-items:flex-start;
        margin-bottom:18px
    }

    .avatar{
        width:72px;
        height:72px;
        border-radius:50%;
        background:linear-gradient(135deg,var(--rb-600),var(--rb-500));
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-family:'Poppins',sans-serif;
        font-weight:700;
        font-size:28px;
        flex-shrink:0
    }

    .name{
        font-family:'Poppins',sans-serif;
        font-size:28px;
        font-weight:700;
        color:var(--rb-900);
        margin:0
    }

    .meta{
        color:var(--muted);
        margin-top:6px;
        line-height:1.6
    }
    
    .badge{
        display:inline-flex;
        align-items:center;
        padding:7px 12px;
        border-radius:999px;
        background:var(--rb-50);
        color:var(--rb-700);
        font-weight:700;
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.5px
    }

    .section{
        font-family:'Poppins',sans-serif;
        font-size:18px;
        font-weight:600;
        color:var(--rb-900);
        margin:0 0 12px
    }

    .info-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px
    }

    .info{
        background:var(--rb-50);
        border-radius:14px;
        padding:14px
    }

    .info .lbl{
        font-size:12px;
        font-weight:700;
        color:var(--rb-700);
        text-transform:uppercase;
        letter-spacing:.5px
    }

    .info .val{
        margin-top:6px;
        color:var(--rb-900);
        font-weight:600
    }

    .summary{
        color:var(--ink);
        line-height:1.75
    }

    .list{
        margin:0;
        padding-left:18px;
        color:var(--ink);
        line-height:1.75
    }

    .skills{
        display:flex;
        flex-wrap:wrap;
        gap:10px
    }

    .skill{
        padding:8px 12px;
        border-radius:999px;
        background:#fff;
        border:1px solid var(--line);
        color:var(--rb-700);
        font-weight:700;
        font-size:13px
    }

    .resume-box{
        border:1px dashed var(--line);
        border-radius:14px;
        padding:16px;
        background:#fff
    }

    .resume-title{
        font-family:'Poppins',sans-serif;
        font-weight:600;
        color:var(--rb-900);
        margin:0 0 10px
    }

    .resume-line{
        margin:0 0 10px;
        color:var(--ink);
        line-height:1.7
    }

    .resume-preview{
        border:1px solid var(--line);
        border-radius:12px;
        padding:16px;
        background:#f8fafc;
        white-space:pre-wrap;
        line-height:1.7;
        color:var(--ink);
        max-height:420px;
        overflow:auto
    }

    .actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
        margin-top:18px
    }

    .btn{
        padding:10px 16px;
        font-size:13px;
        font-weight:700;
        border-radius:10px;
        cursor:pointer;
        border:none;
        font-family:'Inter',sans-serif;
        transition:.15s;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        justify-content:center
    }

    .btn-primary{
        background:var(--rb-600);
        color:#fff
    }

    .btn-primary:hover{
        background:var(--rb-700)
    }

    .btn-ghost{
        background:#fff;
        color:var(--rb-700);
        border:1px solid var(--line)
    }
</style>

<div class="ad-wrap">
    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #86efac;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif
    <a class="ad-back" href="{{ route('applications.review', $job->id) }}">← Back to applicants</a>
    
    <div class="ad-grid">
        <div class="card">
            <div class="head">
                <div style="display:flex;gap:18px;align-items:flex-start;">
                    <div class="avatar">{{ strtoupper(substr($applicant->name, 0, 1)) }}</div>
                    <div>
                        <h1 class="name">{{ $applicant->name }}</h1>
                        <div class="meta">{{ $applicant->email }}<br>{{ $profile->phone ?? 'No phone listed' }} • {{ $profile->location ?? 'No location listed'}}</div>
                    </div>
                </div>
                <div class="badge">{{ ucfirst($application->status) }}</div>
            </div>

            <h2 class="section">Applicant Info</h2>
            <div class="info-grid">
                <div class="info"><div class="lbl">Role</div><div class="val">Applying for {{ $job->title }}</div></div>
                <div class="info"><div class="lbl">Company</div><div class="val">{{ $job->company }}</div></div>
                <div class="info"><div class="lbl">Experience</div><div class="val">{{ $profile->experience ?: 'Not specified' }}</div></div>
                <div class="info"><div class="lbl">Education</div><div class="val">{{ $profile->education ?: 'Not specified' }}</div></div>
                <div class="info"><div class="lbl">Applied On</div><div class="val">{{ $application->created_at->format('M d, Y') }}</div></div>
                <div class="info"><div class="lbl">Status</div><div class="val">{{ ucfirst($application->status) }}</div></div>
            </div>

            <div style="margin-top:18px;">
                <h2 class="section">Skills</h2>
                <div class="skills">
                    @if ($profile && $profile->skills)
                        @foreach (explode(',', $profile->skills) as $skill)
                            <span class="skill">{{ trim($skill) }}</span>
                        @endforeach
                    @else
                        <p>No skills listed.</p>
                    @endif
                </div>
            </div>
        </div>

        <aside class="card">
            <h2 class="section">Resume</h2>
            <div class="resume-box">
                @if ($profile && $profile->resume_path)
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <a class="btn btn-primary" href="{{ route('applications.applicant.resume', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}">Download Resume</a>
                        <button class="btn btn-ghost" onclick="document.getElementById('resume-preview-modal').style.display='flex'">Preview Resume</button>
                    </div>
                @else
                    <p>No resume uploaded.</p>
                @endif
            </div>

            <div style="margin-top:18px;">
                <h2 class="section">Update Application Status</h2>
                <form method="POST" action="{{ route('applications.applicant.updateStatus', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}">
                    @csrf
                    <select name="status" class="filter-select" style="margin-bottom:10px;">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="interview" {{ $application->status === 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="width:100%;">Update Status</button>
                </form>
            </div>

            <div class="actions">
                <button class="btn btn-primary" onclick="document.getElementById('email-modal').style.display='flex'">Email Applicant</button>
                <a class="btn btn-ghost" href="{{ route('applications.review', $job->id) }}">Back to Tracking</a>
            </div>
        </aside>
    </div>
</div>

<div id="email-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:50;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:32px;width:100%;max-width:520px;box-shadow:0 24px 60px rgba(15,23,42,.18);font-family:'Inter',sans-serif;">
        <h2 style="margin:0 0 6px;font-family:'Poppins',sans-serif;color:#0f1e46;font-size:1.4rem;">Email Applicant</h2>
        <p style="margin:0 0 20px;color:#64748b;font-size:0.9rem;">This sends a message directly to {{ $applicant->name }}.</p>

        <form method="POST" action="{{ route('applications.email', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#0f172a;margin-bottom:6px;">Recipient</label>
                <input type="email" name="recipient" value="{{ $applicant->email }}" readonly
                    style="width:100%;padding:11px 14px;border:1px solid #e5e7eb;border-radius:8px;font:inherit;background:#f8fafc;color:#64748b;box-sizing:border-box;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#0f172a;margin-bottom:6px;">Subject</label>
                <input type="text" name="subject" placeholder="e.g. Interview Invitation" required
                    style="width:100%;padding:11px 14px;border:1px solid #e5e7eb;border-radius:8px;font:inherit;box-sizing:border-box;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#0f172a;margin-bottom:6px;">Message</label>
                <textarea name="body" rows="5" placeholder="Write your message here..." required
                    style="width:100%;padding:11px 14px;border:1px solid #e5e7eb;border-radius:8px;font:inherit;resize:vertical;box-sizing:border-box;"></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('email-modal').style.display='none'"
                    class="btn btn-ghost">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Email</button>
            </div>
        </form>
    </div>
</div>

<div id="resume-preview-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:24px;width:95%;max-width:860px;height:90vh;display:flex;flex-direction:column;box-shadow:0 24px 60px rgba(15,23,42,.2);font-family:'Inter',sans-serif;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h2 style="margin:0;font-family:'Poppins',sans-serif;color:#0f1e46;font-size:1.3rem;">{{ $applicant->name }}'s Resume</h2>
            <button onclick="document.getElementById('resume-preview-modal').style.display='none'"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#64748b;">✕</button>
        </div>
        <iframe src="{{ route('applications.applicant.resume.preview', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}"
            style="flex:1;border:1px solid #e5e7eb;border-radius:10px;width:100%;"
            type="application/pdf">
            <p>Your browser cannot display PDFs inline. <a href="{{ route('applications.applicant.resume', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}">Download instead.</a></p>
        </iframe>
    </div>
</div>
@endsection