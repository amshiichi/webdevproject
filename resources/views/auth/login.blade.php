@extends('layouts.app')

@section('title', 'Log In')

@section('content')
<style>
    .auth-shell {
        max-width: 1180px;
        margin: 0 auto;
        padding: 48px 24px 72px;
    }

    .auth-card {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        min-height: 720px;
        border-radius: 32px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(16, 42, 114, 0.10);
        box-shadow: 0 24px 70px rgba(16, 42, 114, 0.14);
    }

    .auth-aside {
        position: relative;
        padding: 56px;
        color: #fff;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,0.18), transparent 30%),
            linear-gradient(135deg, #0b1e57 0%, #1d4ed8 100%);
    }

    .auth-aside h1,
    .auth-panel h2 {
        font-family: 'Poppins', sans-serif;
        letter-spacing: -0.05em;
        margin: 0;
    }

    .auth-aside h1 {
        font-size: clamp(2.8rem, 5vw, 4.6rem);
        line-height: 0.95;
        color: #fff;
        margin-top: 18px;
        max-width: 10ch;
    }

    .auth-aside p {
        max-width: 520px;
        margin: 22px 0 0;
        color: rgba(255,255,255,0.84);
        line-height: 1.8;
        font-size: 1.04rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255,255,255,0.12);
        font-weight: 700;
    }

    .auth-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 32px;
    }

    .metric {
        padding: 18px;
        border-radius: 22px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
    }

    .metric strong {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 1.9rem;
        line-height: 1;
        margin-bottom: 8px;
    }

    .metric span { color: rgba(255,255,255,0.8); }

    .auth-panel {
        padding: 56px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }

    .auth-panel h2 {
        font-size: 2.1rem;
        color: #0b1e57;
    }

    .auth-panel p {
        margin: 10px 0 28px;
        color: #64748b;
        line-height: 1.7;
    }

    .field {
        margin-bottom: 18px;
    }

    .field label {
        display: block;
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .field input,
    .field select {
        width: 100%;
        border: 1px solid rgba(16, 42, 114, 0.12);
        background: #fff;
        border-radius: 18px;
        padding: 16px 18px;
        font: inherit;
        outline: none;
    }

    .field input:focus,
    .field select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    .auth-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 18px 0 28px;
        color: #64748b;
        font-size: 0.95rem;
    }

    .auth-meta a {
        color: #1d4ed8;
        font-weight: 700;
    }

    .auth-button {
        width: 100%;
        border: none;
        border-radius: 999px;
        padding: 16px 22px;
        font: inherit;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #0b1e57);
        box-shadow: 0 18px 36px rgba(29, 78, 216, 0.24);
        cursor: pointer;
    }

    .switch-box {
        margin-top: 20px;
        padding: 18px 20px;
        border-radius: 20px;
        background: rgba(224, 242, 254, 0.75);
        color: #0b1e57;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .switch-box span {
        font-weight: 700;
    }

    .switch-box .button-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border-radius: 999px;
        background: #fff;
        color: #0b1e57;
        font-weight: 800;
        border: 1px solid rgba(16, 42, 114, 0.12);
    }

    @media (max-width: 980px) {
        .auth-card { grid-template-columns: 1fr; }
        .auth-aside,
        .auth-panel { padding: 34px; }
    }
</style>

<div class="auth-shell">
    <div class="auth-card">
        <aside class="auth-aside">
            <div class="badge"><i class="bi bi-stars"></i> ApplyHub</div>
            <h1>Welcome back to your job search.</h1>
            <p>
                Log in to continue browsing featured roles, save jobs, and track applications inside the same polished hiring experience.
            </p>

            <div class="auth-metrics">
                <div class="metric">
                    <strong>250+</strong>
                    <span>live listings</span>
                </div>
                <div class="metric">
                    <strong>24/7</strong>
                    <span>job discovery</span>
                </div>
            </div>
        </aside>

        <section class="auth-panel">
            <h2>Log In</h2>
            <p>Enter your details to get back into the board.</p>

            @if ($errors->any())
                <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="auth-meta">
                    <label style="display:flex; align-items:center; gap:8px; margin:0; font-weight:600; color:#475569;">
                        <input type="checkbox" name="remember" style="width:auto; margin:0;">
                        Remember me
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="auth-button">Log In</button>
            </form>

            <div class="switch-box">
                <span>Need an account?</span>
                <a class="button-link" href="{{ route('register') }}">Sign up</a>
            </div>
        </section>
    </div>
</div>
@endsection