@extends('layouts.app')
@section('content')
<style>
    .ad-wrap{max-width:1100px;margin:42px auto 100px;padding:0 24px;font-family:'Inter',sans-serif;color:var(--ink)}
    .ad-back{display:inline-flex;align-items:center;gap:8px;color:var(--rb-700);text-decoration:none;font-weight:700;margin-bottom:18px}
    .ad-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:20px}
    @media(max-width:900px){.ad-grid{grid-template-columns:1fr}}
    .card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:24px;box-shadow:0 1px 2px rgba(15,23,42,.04)}
    .head{display:flex;justify-content:space-between;gap:16px;align-items:flex-start;margin-bottom:18px}
    .avatar{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--rb-600),var(--rb-500));color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:28px;flex-shrink:0}
    .name{font-family:'Poppins',sans-serif;font-size:28px;font-weight:700;color:var(--rb-900);margin:0}
    .meta{color:var(--muted);margin-top:6px;line-height:1.6}
    .badge{display:inline-flex;align-items:center;padding:7px 12px;border-radius:999px;background:var(--rb-50);color:var(--rb-700);font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.5px}
    .section{font-family:'Poppins',sans-serif;font-size:18px;font-weight:600;color:var(--rb-900);margin:0 0 12px}
    .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
    .info{background:var(--rb-50);border-radius:14px;padding:14px}
    .info .lbl{font-size:12px;font-weight:700;color:var(--rb-700);text-transform:uppercase;letter-spacing:.5px}
    .info .val{margin-top:6px;color:var(--rb-900);font-weight:600}
    .summary{color:var(--ink);line-height:1.75}
    .list{margin:0;padding-left:18px;color:var(--ink);line-height:1.75}
    .skills{display:flex;flex-wrap:wrap;gap:10px}
    .skill{padding:8px 12px;border-radius:999px;background:#fff;border:1px solid var(--line);color:var(--rb-700);font-weight:700;font-size:13px}
    .resume-box{border:1px dashed var(--line);border-radius:14px;padding:16px;background:#fff}
    .resume-title{font-family:'Poppins',sans-serif;font-weight:600;color:var(--rb-900);margin:0 0 10px}
    .resume-line{margin:0 0 10px;color:var(--ink);line-height:1.7}
    .resume-preview{border:1px solid var(--line);border-radius:12px;padding:16px;background:#f8fafc;white-space:pre-wrap;line-height:1.7;color:var(--ink);max-height:420px;overflow:auto}
    .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:18px}
    .btn{padding:10px 16px;font-size:13px;font-weight:700;border-radius:10px;cursor:pointer;border:none;font-family:'Inter',sans-serif;transition:.15s;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
    .btn-primary{background:var(--rb-600);color:#fff}
    .btn-primary:hover{background:var(--rb-700)}
    .btn-ghost{background:#fff;color:var(--rb-700);border:1px solid var(--line)}
</style>

<div class="ad-wrap">
    <a class="ad-back" href="{{ route('applications.review', $job->id) }}">← Back to applicants</a>

    <div class="ad-grid">
        <div class="card">
            <div class="head">
                <div style="display:flex;gap:18px;align-items:flex-start;">
                    <div class="avatar">{{ strtoupper(substr($applicant->name, 0, 1)) }}</div>
                    <div>
                        <h1 class="name">{{ $applicant->name }}</h1>
                        <div class="meta">{{ $applicant->email }}<br>{{ $applicant->phone }} • {{ $applicant->location }}</div>
                    </div>
                </div>
                <div class="badge">{{ $applicant->experience }}</div>
            </div>

            <h2 class="section">Applicant Info</h2>
            <div class="info-grid">
                <div class="info"><div class="lbl">Experience</div><div class="val">{{ $applicant->experience }}</div></div>
                <div class="info"><div class="lbl">Education</div><div class="val">{{ $applicant->education }}</div></div>
                <div class="info"><div class="lbl">Role</div><div class="val">Applying for {{ $job->title }}</div></div>
                <div class="info"><div class="lbl">Company</div><div class="val">{{ $job->company }}</div></div>
            </div>

            <div style="margin-top:18px;">
                <h2 class="section">Summary</h2>
                <p class="summary">{{ $applicant->summary }}</p>
            </div>

            <div style="margin-top:18px;">
                <h2 class="section">Skills</h2>
                <div class="skills">
                    @foreach ($applicant->skills as $skill)
                        <span class="skill">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="card">
            <h2 class="section">Resume</h2>
            <div class="resume-box">
                <p class="resume-title">Resume Preview</p>
                <div class="resume-preview">{{ $resumeText }}</div>
                <div class="actions" style="margin-top: 14px;">
                    <a class="btn btn-primary" href="{{ route('applications.applicant.resume', ['jobId' => $job->id, 'applicantId' => $applicant->id]) }}">Download Resume</a>
                </div>
            </div>

            <div style="margin-top:18px;">
                <h2 class="section">Contact</h2>
                <p class="resume-line">Email: {{ $applicant->email }}<br>Phone: {{ $applicant->phone }}<br>Location: {{ $applicant->location }}</p>
            </div>

            <div class="actions">
                <a class="btn btn-primary" href="mailto:{{ $applicant->email }}">Email Applicant</a>
                <a class="btn btn-ghost" href="{{ route('applications.review', $job->id) }}">Back to Tracking</a>
            </div>
        </aside>
    </div>
</div>
@endsection