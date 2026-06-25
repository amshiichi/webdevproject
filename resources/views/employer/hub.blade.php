@extends('layouts.app')
@section('title', 'Job Hub')
@section('content')
<style>
    .job-hub { 
        max-width: 980px; 
        margin: 48px auto; 
        padding: 0 24px; 
        font-family: 'Inter', system-ui, sans-serif; 
    }
    
    .job-hub-card { 
        background:#fff;
        border:1px solid #eef2ff;
        border-radius:18px;
        padding:28px; 
    }
    
    .job-hub h1 { 
        margin:0 0 8px;
        font-size:30px;
        color:#0f172a 
    }
    
    .job-hub p { 
        margin:0 0 20px;
        color:#334155 
    }

    .job-hub-actions { 
        display:grid;
        grid-template-columns: 320px 1fr;
        gap:18px;
        align-items:start 
    }

    .post-card { 
        display:block;
        padding:20px;
        border-radius:12px;
        background:#fff;
        border:1px solid #e0e7ff;
        text-decoration:none;
        color:#0f172a 
    }
    
    .post-card .title{
        font-size:18px;
        font-weight:700;
        margin-bottom:8px
    }
    
    .post-card .desc{
        color:#475569;
        font-size:14px
    }

    .back-card{
        display:block;
        padding:14px 20px;
        border-radius:12px;
        background:#fff;
        border:1px solid #e0e7ff;
        text-decoration:none;
        color:#1e40af;
        font-weight:600;
        text-align:center;
        margin-top:12px;
        cursor:pointer;
    }

    .back-card:hover{
        background:#f8fafc;
    }

    .jobs-list{
        display:flex;
        flex-direction:column;
        gap:12px
    }
    
    .job-item{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:14px 16px;
        border-radius:10px;
        background:#f8fafc;
        border:1px solid #f1f5f9
    }
    
    .job-item .meta{
        display:flex;
        flex-direction:column
    }
    
    .job-item .title{
        font-weight:700;
        color:#0f172a
    }
    
    .job-item .date{
        font-size:13px;
        color:#64748b
    }
    
    .btn-sm{
        padding:8px 12px;
        border-radius:8px;
        font-weight:600;
        background:#eef2ff;
        color:#1e40af;
        border:1px solid transparent;
        text-decoration:none
    }
    
    .btn-sm:hover{
        background:#e0e7ff
    }

    @media (max-width:720px){ 
        .job-hub-actions{grid-template-columns:1fr} 
        .post-card{order:0} 
    }
</style>

<div class="job-hub">
    <div class="job-hub-card">
        <h1>Job</h1>
        <p>Choose what you want to do next: create a new posting or edit an existing one.</p>

        <div class="job-hub-actions">
            <div>
                <a class="post-card" href="{{ route('jobs.create') }}">
                    <div class="title">Post a Job</div>
                    <div class="desc">Quickly create and publish a new job posting.</div>
                </a>

                <button
                    type="button"
                    class="back-card"
                    onclick="window.history.back();">
                    ← Back
                </button>
            </div>

            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                    <div style="font-weight:700;color:#0f172a">Your posts</div>
                    <div style="color:#64748b;font-size:13px">{{ count($jobs) }} total</div>
                </div>

                <div class="jobs-list">
                    @if(!empty($jobs))
                        @foreach($jobs as $job)
                            <div class="job-item">
                                <div class="meta">
                                    <div class="title">{{ $job->title }}</div>
                                    <div class="date">Posted on {{ $job->created_at }}</div>
                                </div>
                                <div style="display:flex;gap:8px">
                                    <a class="btn-sm" href="{{ route('jobs.edit', $job->id) }}">Edit</a>
                                    <form action="{{ route('jobs.destroy',$job->id) }}" method="POST" onsubmit="return confirm('Delete this job permanently?')">
                                        @csrf
                                        <button type="submit" class="btn-sm" style="background:#fee2e2;color:#dc2626;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="job-item">No jobs found. Create your first post.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
