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
        @php($isEmployer = $user->role === 'employer')
        <div class="ep-head">
            <div class="ep-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
            <div>
                <h1>{{ $isEmployer ? 'Edit Company Profile' : 'Edit Profile' }}</h1>
                <div class="sub">{{ $isEmployer ? 'Update your company details and reviews.' : 'Update your details and resume.' }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label>{{ $isEmployer ? 'Company Name' : 'Full Name' }}</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="{{ $isEmployer ? 'Your company name' : 'Your full name' }}">
            </div>

            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="you@example.com">
            </div>

            <div class="field">
                <label>{{ $isEmployer ? 'About Us' : 'Bio' }}</label>
                <textarea name="bio" placeholder="{{ $isEmployer ? 'Tell applicants about your company...' : 'Tell employers about yourself...' }}">{{ old('bio', $user->bio ?? '') }}</textarea>
            </div>

            <div class="field">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+639123456789">
            </div>

            <div class="field">
                <label>Location</label>
                <input type="text" name="location" value="{{ old('location', $user->location ?? '') }}" placeholder="e.g. Manila, PH">
            </div>

            @if ($isEmployer)
            @else

                <div class="field">
                    <label>Education</label>
                    <input type="text" name="education" value="{{ old('education', $user->education ?? '') }}" placeholder="e.g. BS Information Technology">
                </div>

                <div class="field">
                    <label>Experience</label>
                    <input type="text" name="experience" value="{{ old('experience', $user->experience ?? '') }}" placeholder="e.g. 3 years">
                </div>

                <div class="field">
                    <label>Skills</label>
                    <textarea name="skills" placeholder="e.g. HTML, CSS, JavaScript, PHP, Laravel, MySQL">{{ old('skills', $user->skills ?? '') }}</textarea>
                </div>

                <div class="field">
                    <label>Resume (PDF)</label>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <label class="file-drop" style="display: block; cursor: pointer;">
                            <div class="ic">⬆</div>
                            <div class="upload-text">Click to upload or drag & drop</div>
                            <div class="hint">PDF up to 5MB</div>
                            <input id="resume-input" type="file" name="resume" accept="application/pdf" style="display: none;">
                        </label>
                        <div id="resume-file-name" style="font-size:14px;color:#475569;">
                            @if($user->resume_path)
                                Current resume: <strong>{{ basename($user->resume_path) }}</strong>
                            @else
                                No resume uploaded yet.
                            @endif
                        </div>
                    </div>
                </div>

            @endif

            <div class="actions">
                <a href="{{ route('profile.show') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('resume-input');
        const fileNameDisplay = document.getElementById('resume-file-name');

        if (!fileInput || !fileNameDisplay) return;

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file) {
                fileNameDisplay.innerHTML = 'Selected file: <strong>' + file.name + '</strong> — ready to save.';
            } else {
                fileNameDisplay.innerHTML = '{{ $user->resume_path ? "Current resume: <strong>" . basename($user->resume_path) . "</strong>" : "No resume uploaded yet." }}';
            }
        });
    });
</script>
@endsection