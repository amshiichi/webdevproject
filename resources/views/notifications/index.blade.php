@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<style>
    :root {
        --royal-blue-deep: #0f1e46;
        --royal-blue-main: #1e40af;
        --royal-blue-bright: #2563eb;
        --royal-blue-light: #eff6ff;
        --royal-blue-tint: #dbeafe;
        --pure-white: #ffffff;
        --muted: #64748b;
    }

    .notify-wrap {
        max-width: 1100px;
        margin: 56px auto 100px;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .notify-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 18px 44px rgba(30, 64, 175, 0.06);
    }

    .notify-head {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: end;
        margin-bottom: 24px;
    }

    .notify-head h1 {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2rem, 4vw, 3rem);
        color: var(--royal-blue-deep);
        letter-spacing: -0.04em;
    }

    .notify-head p {
        margin: 8px 0 0;
        color: var(--muted);
    }

    .notice-list {
        display: grid;
        gap: 16px;
    }

    .notice {
        display: flex;
        gap: 16px;
        padding: 18px 20px;
        border-radius: 20px;
        background: var(--royal-blue-light);
        border: 1px solid var(--royal-blue-tint);
    }

    .notice-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, var(--royal-blue-bright), var(--royal-blue-deep));
        color: #fff;
        flex-shrink: 0;
    }

    .notice strong {
        display: block;
        color: var(--royal-blue-deep);
        font-size: 1rem;
        margin-bottom: 4px;
    }

    .notice p {
        margin: 0;
        color: var(--muted);
        line-height: 1.65;
    }

    .notify-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 999px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        transition: transform .2s ease, background-color .2s ease, color .2s ease;
    }

    .button:hover { transform: translateY(-1px); }
    .button-primary {
        background: linear-gradient(135deg, var(--royal-blue-bright), var(--royal-blue-deep));
        color: #fff;
    }
    .button-ghost {
        background: #fff;
        color: var(--royal-blue-deep);
        border-color: rgba(16, 42, 114, 0.12);
    }
</style>

<div class="notify-wrap">
    <div class="notify-card">
        <div class="notify-head">
            <div>
                <h1>Notifications</h1>
                <p>Updates about your profile, saved jobs, and applications.</p>
            </div>
            <a class="button button-ghost" href="{{ route('profile.edit') }}"><i class="bi bi-pencil-square"></i> Edit Profile</a>
        </div>

        <div class="notice-list">
            @forelse ($notifications as $notification)
                <div class="notice" @if(!$notification->is_read) style="background-color: #eff6ff; border-left: 4px solid #3b82f6;" @endif>
                    <div class="notice-icon">
                        @if(str_contains(strtolower($notification->message), 'job'))
                            <i class="bi bi-bookmark-check-fill"></i>
                        @elseif(str_contains(strtolower($notification->message), 'application') || str_contains(strtolower($notification->message), 'apply'))
                            <i class="bi bi-envelope-paper-fill"></i>
                        @else
                            <i class="bi bi-bell-fill"></i>
                        @endif
                    </div>
                    
                    <div>
                        <p style="margin: 0; font-weight: 500;">{{ $notification->message }}</p>
                        <small style="color: #64748b; display: block; margin-top: 4px;">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                        
                        @if ($notification->link)
                            <div style="margin-top: 8px;">
                                <a href="{{ $notification->link }}" class="link-primary" style="text-decoration: none; font-size: 0.9rem;">
                                    View Update →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="notice" style="justify-content: center; padding: 32px; color: #64748b;">
                    <div>
                        <i class="bi bi-chat-left-dots" style="font-size: 1.5rem; display: block; text-align: center; margin-bottom: 8px;"></i>
                        <p style="margin: 0;">You have no notifications at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="notify-actions">
            <a class="button button-primary" href="{{ route('jobs.public') }}"><i class="bi bi-search"></i> Browse Jobs</a>
            <a class="button button-ghost" href="{{ route('jobs.index') }}"><i class="bi bi-house-fill"></i> Applicant Home</a>
        </div>
    </div>
</div>
@endsection
