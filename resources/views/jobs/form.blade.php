<!--
A shared file used for both creating and editing a job post (Employer only).
-->
<!-- Shared file for creating and editing a job post (Employer only). -->
@extends('layouts.app')

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

    .form-wrap {
        max-width: 900px; 
        margin: 60px auto 100px auto;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .form-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 24px; 
        padding: 48px; 
        box-shadow: 0 16px 40px rgba(30, 64, 175, 0.03);
    }

    .form-card h1 {
        font-size: 36px; 
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin: 0 0 8px;
        letter-spacing: -0.5px;
    }

    .form-card .sub {
        color: var(--royal-blue-main);
        font-size: 16px; 
        margin-bottom: 36px;
        font-weight: 500;
    }

    .field {
        margin-bottom: 28px; 
    }

    .field label {
        display: block;
        font-size: 16px; 
        font-weight: 700;
        color: var(--royal-blue-deep);
        margin-bottom: 10px;
        letter-spacing: 0.2px;
    }

    .field input, 
    .field textarea, 
    .field select {
        width: 100%;
        padding: 16px 20px; 
        font-size: 17px; 
        font-family: 'Inter', sans-serif;
        color: var(--royal-blue-deep);
        border: 2px solid var(--royal-blue-tint);
        border-radius: 12px;
        background: var(--pure-white);
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .field select {
        height: 58px;
        cursor: pointer;
    }

    .field input::placeholder,
    .field textarea::placeholder {
        color: rgba(15, 30, 70, 0.4);
    }

    .field input:focus, 
    .field textarea:focus, 
    .field select:focus {
        outline: none;
        border-color: var(--royal-blue-bright);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        background: var(--pure-white);
    }

    .field textarea {
        min-height: 160px; 
        resize: vertical;
    }

    .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px; 
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 40px;
    }

    .btn {
        padding: 14px 32px; 
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        cursor: pointer;
        border: none;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: var(--royal-blue-bright);
        color: var(--pure-white);
    }

    .btn-primary:hover {
        background: var(--royal-blue-main);
        transform: translateY(-1px);
    }

    .btn-ghost {
        background: transparent;
        color: var(--royal-blue-main);
        border: 2px solid var(--royal-blue-tint);
    }

    .btn-ghost:hover {
        background: var(--royal-blue-light);
        border-color: var(--royal-blue-main);
    }
</style>

<div class="form-wrap">
    <div class="form-card">
        <h1>{{ isset($job) ? 'Edit Job Posting' : 'Create a New Job Posting' }}</h1>
        <div class="sub">Fill in the details below to {{ isset($job) ? 'update' : 'publish' }} this opportunity.</div>

        <form method="POST" action="{{ isset($job) ? route('jobs.update', $job->id) : route('jobs.store') }}">
            @csrf
            @isset($job) @method('PUT') @endisset

            <div class="field">
                <label>Job Title</label>
                <input type="text" name="title" value="{{ $job->title ?? '' }}" placeholder="e.g. Senior Frontend Developer">
            </div>

            <div class="row">
                <div class="field">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ $job->location ?? '' }}" placeholder="e.g. Manila, PH">
                </div>
                <div class="field">
                    <label>Job Type</label>
                    <select name="type">
                        <option value="full-time" {{ (old('type', $job->type ?? '') == 'full-time') ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ (old('type', $job->type ?? '') == 'part-time') ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ (old('type', $job->type ?? '') == 'contract') ? 'selected' : '' }}>Contract</option>
                        <option value="internship" {{ (old('type', $job->type ?? '') == 'internship') ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Salary Range</label>
                <input type="text" name="salary" value="{{ $job->salary ?? '' }}" placeholder="e.g. ₱40,000 – ₱60,000">
            </div>

            <div class="field">
                <label>Description</label>
                <textarea name="description" placeholder="Describe the role, responsibilities, and team...">{{ $job->description ?? '' }}</textarea>
            </div>

            <div class="field">
                <label>Requirements</label>
                <textarea name="requirements" placeholder="List required skills, experience, and qualifications...">{{ $job->requirements ?? '' }}</textarea>
            </div>

            <div class="actions">
                <a href="{{ route('jobs.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ isset($job) ? 'Save Changes' : 'Publish Job' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
