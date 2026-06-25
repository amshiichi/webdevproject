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
                @php
                    $decoded = null;
                    $isEmail = false;
                    if ($notification->message && str_starts_with(trim($notification->message), '{')) {
                        try {
                            $decoded = json_decode($notification->message, true);
                            $isEmail = isset($decoded['type']) && $decoded['type'] === 'email';
                        } catch (\Exception $e) {}
                    }
                    $displayMessage = $isEmail ? $decoded['preview'] : $notification->message;
                @endphp

                <div class="notice" style="{{ $notification->is_read ? 'background-color:#f1f5f9;border-left:4px solid #cbd5e1;opacity:0.75;' : 'background-color:#eff6ff;border-left:4px solid #3b82f6;' }}">
                    <div class="notice-icon">
                        @if($isEmail)
                            <i class="bi bi-envelope-fill"></i>
                        @elseif(str_contains(strtolower($displayMessage), 'job'))
                            <i class="bi bi-bookmark-check-fill"></i>
                        @elseif(str_contains(strtolower($displayMessage), 'application') || str_contains(strtolower($displayMessage), 'apply'))
                            <i class="bi bi-envelope-paper-fill"></i>
                        @else
                            <i class="bi bi-bell-fill"></i>
                        @endif
                    </div>

                    <div style="flex:1;">
                        <p style="margin:0;font-weight:500;">{{ $displayMessage }}</p>
                        <small style="color:#64748b;display:block;margin-top:4px;">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>

                        <div style="margin-top:10px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                            @if($isEmail)
                                <button type="button"
                                    onclick="openEmailPanel('{{ addslashes($decoded['from']) }}', '{{ addslashes($decoded['subject']) }}', '{{ addslashes($decoded['body']) }}', {{ $notification->id }})"
                                    style="background:none;border:none;padding:0;cursor:pointer;color:#2563eb;font-size:0.9rem;font-weight:600;">
                                    View Email →
                                </button>
                            @elseif($notification->link)
                                @php
                                    try {
                                        $parsed = parse_url($notification->link, PHP_URL_PATH);
                                        app('router')->getRoutes()->match(\Illuminate\Http\Request::create($parsed));
                                        $linkValid = true;
                                    } catch (\Exception $e) {
                                        $linkValid = false;
                                    }
                                @endphp
                                @if($linkValid)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;color:#2563eb;font-size:0.9rem;font-weight:600;">
                                            View Update →
                                        </button>
                                    </form>
                                @endif
                            @endif

                            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;color:#dc2626;font-size:0.85rem;font-weight:600;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="notice" style="justify-content:center;padding:32px;color:#64748b;">
                    <div>
                        <i class="bi bi-chat-left-dots" style="font-size:1.5rem;display:block;text-align:center;margin-bottom:8px;"></i>
                        <p style="margin:0;">You have no notifications at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Email Viewer Panel --}}
        <div id="email-viewer-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:50;align-items:center;justify-content:center;">
            <div style="background:#fff;border-radius:20px;padding:32px;width:100%;max-width:560px;box-shadow:0 24px 60px rgba(15,23,42,.18);font-family:'Inter',sans-serif;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <h2 style="margin:0;font-family:'Poppins',sans-serif;color:#0f1e46;font-size:1.3rem;">Received Email</h2>
                    <button onclick="closeEmailPanel()" style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#64748b;">✕</button>
                </div>
                <div style="margin-bottom:12px;">
                    <span style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;">From</span>
                    <p id="ev-from" style="margin:4px 0 0;font-weight:600;color:#0f1e46;"></p>
                </div>
                <div style="margin-bottom:12px;">
                    <span style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;">Subject</span>
                    <p id="ev-subject" style="margin:4px 0 0;font-weight:600;color:#0f1e46;"></p>
                </div>
                <div style="margin-bottom:24px;">
                    <span style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;">Message</span>
                    <p id="ev-body" style="margin:4px 0 0;color:#334155;line-height:1.7;white-space:pre-wrap;"></p>
                </div>
                <div style="text-align:right;">
                    <button onclick="closeEmailPanel()" style="padding:10px 22px;border-radius:999px;border:1px solid rgba(16,42,114,0.15);background:#f8fafc;font:inherit;font-weight:700;color:#0b1e57;cursor:pointer;">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <div class="notify-actions">
            <a class="button button-primary" href="{{ route('jobs.public') }}"><i class="bi bi-search"></i> Browse Jobs</a>
            <a class="button button-ghost" href="{{ route('jobs.index') }}"><i class="bi bi-house-fill"></i> Applicant Home</a>
        </div>
    </div>
</div>

<script>
function openEmailPanel(from, subject, body, notifId) {
    document.getElementById('ev-from').textContent = from;
    document.getElementById('ev-subject').textContent = subject;
    document.getElementById('ev-body').textContent = body;
    document.getElementById('email-viewer-modal').style.display = 'flex';

    // Mark as read
    fetch('/notifications/' + notifId + '/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => {
        // Fade the notification card visually
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            if (btn.textContent.trim() === 'View Email →') {
                const card = btn.closest('.notice');
                if (card) {
                    card.style.backgroundColor = '#f1f5f9';
                    card.style.borderLeft = '4px solid #cbd5e1';
                    card.style.opacity = '0.75';
                }
            }
        });
    });
}

function closeEmailPanel() {
    document.getElementById('email-viewer-modal').style.display = 'none';
}
</script>
@endsection
