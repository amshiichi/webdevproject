<!--
The form to update details or upload a new PDF resume.
-->
<!-- Form to update profile details or upload a new PDF resume. -->
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

    .ep-wrap {
        max-width: 900px;
        margin: 60px auto 100px auto;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .ep-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 24px; 
        padding: 48px; 
        box-shadow: 0 16px 40px rgba(30, 64, 175, 0.03);
    }

    .ep-head {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 36px;
        padding-bottom: 28px;
        border-bottom: 2px solid var(--royal-blue-light);
    }

    .ep-avatar {
        width: 88px; 
        height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--royal-blue-main), var(--royal-blue-bright));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pure-white);
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 32px; 
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
    }

    .ep-head h1 {
        font-size: 34px; 
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .ep-head .sub {
        color: var(--royal-blue-main);
        font-size: 16px; 
        margin-top: 6px;
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
    }

    .field input, 
    .field textarea {
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

    .field input::placeholder,
    .field textarea::placeholder {
        color: rgba(15, 30, 70, 0.4);
    }

    .field input:focus, 
    .field textarea:focus {
        outline: none;
        border-color: var(--royal-blue-bright);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        background: var(--pure-white);
    }

    .field textarea {
        min-height: 160px;
        resize: vertical;
    }

    .file-drop {
        border: 2px dashed var(--royal-blue-bright);
        border-radius: 16px;
        padding: 36px; 
        text-align: center;
        background: var(--royal-blue-light);
        transition: all 0.2s ease;
    }

    .file-drop:hover {
        background: var(--royal-blue-tint);
        border-color: var(--royal-blue-main);
    }

    .file-drop .ic {
        font-size: 40px; 
        color: var(--royal-blue-bright);
        margin-bottom: 10px;
    }

    .file-drop .upload-text {
        font-size: 18px;
        font-weight: 700;
        color: var(--royal-blue-deep);
    }

    .file-drop .hint {
        color: var(--royal-blue-main);
        font-size: 15px;
        margin-top: 6px;
        font-weight: 500;
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

<div class="ep-wrap">
    <div class="ep-card">
        <div class="ep-head">
            <div class="ep-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
            <div>
                <h1>Edit Profile</h1>
                <div class="sub">Update your details and resume.</div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $user->name ?? '' }}" placeholder="Your full name">
            </div>

            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ $user->email ?? '' }}" placeholder="you@example.com">
            </div>

            <div class="field">
                <label>Bio</label>
                <textarea name="bio" placeholder="Tell employers about yourself...">{{ $user->bio ?? '' }}</textarea>
            </div>

            <div class="field">
                <label>Resume (PDF)</label>
                <label class="file-drop" style="display: block; cursor: pointer;">
                    <div class="ic">⬆</div>
                    <div class="upload-text">Click to upload or drag & drop</div>
                    <div class="hint">PDF up to 5MB</div>
                    <input type="file" name="resume" accept="application/pdf" style="display: none;">
                </label>
            </div>

            <div class="actions">
                <a href="{{ route('profile.show') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection