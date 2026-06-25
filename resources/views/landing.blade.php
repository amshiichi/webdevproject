<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApplyHub | Find Your Next Role</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --navy-950: #0b1e57;
            --navy-900: #102a72;
            --navy-800: #183985;
            --blue-700: #1d4ed8;
            --blue-600: #2563eb;
            --sky-100: #e0f2fe;
            --ink: #0f172a;
            --muted: #475569;
            --line: rgba(16, 42, 114, 0.12);
            --white: #ffffff;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.14), transparent 28%),
                radial-gradient(circle at top right, rgba(29, 78, 216, 0.12), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef4ff 46%, #ffffff 100%);
        }
        a {
            color: inherit;
            text-decoration: none;
        }

        .shell {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(14px);
            background: rgba(248, 251, 255, 0.82);
            border-bottom: 1px solid rgba(16, 42, 114, 0.08);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            min-height: 76px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--navy-950);
            font-size: 1.25rem;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--blue-600), var(--navy-900));
            display: grid;
            place-items: center;
            color: var(--white);
            box-shadow: 0 16px 30px rgba(29, 78, 216, 0.25);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            color: var(--muted);
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--navy-950);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 22px;
            border-radius: 999px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease, border-color .2s ease;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button-primary {
            background: linear-gradient(135deg, var(--blue-600), var(--navy-900));
            color: var(--white);
            box-shadow: 0 18px 36px rgba(29, 78, 216, 0.22);
        }
        .button-ghost {
            border-color: rgba(16, 42, 114, 0.14);
            background: rgba(255, 255, 255, 0.74);
            color: var(--navy-900);
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 92px 0 54px;
        }

        .hero::before,
        .hero::after {
            content: '';
            position: absolute;
            inset: auto;
            border-radius: 999px;
            pointer-events: none;
        }
        .hero::before {
            width: 280px;
            height: 280px;
            right: -90px;
            top: 30px;
            background: rgba(59, 130, 246, 0.12);
        }

        .hero::after {
            width: 220px;
            height: 220px;
            left: -90px;
            bottom: -60px;
            background: rgba(29, 78, 216, 0.10);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(224, 242, 254, 0.9);
            color: var(--navy-900);
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .hero h1 {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-size: clamp(3rem, 7vw, 5.4rem);
            line-height: 0.96;
            letter-spacing: -0.06em;
            color: var(--navy-950);
        }

        .hero p {
            margin: 24px 0 0;
            max-width: 620px;
            font-size: 1.12rem;
            line-height: 1.8;
            color: var(--muted);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px;
        }

        .search-panel {
            margin-top: 36px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(16, 42, 114, 0.08);
            border-radius: 28px;
            padding: 18px;
            box-shadow: 0 20px 60px rgba(16, 42, 114, 0.10);
        }

        .search-form {
            display: grid;
            grid-template-columns: 1.3fr 0.9fr 0.7fr auto;
            gap: 12px;
        }

        .field {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px;
            border: 1px solid rgba(16, 42, 114, 0.10);
            border-radius: 18px;
            background: var(--white);
            min-height: 58px;
        }

        .field i {
            color: var(--blue-600);
            font-size: 1.05rem;
        }

        .field input,
        .field select {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font: inherit;
            color: var(--ink);
        }

        .panel-art {
            position: relative;
            min-height: 560px;
            border-radius: 36px;
            background: linear-gradient(160deg, rgba(16, 42, 114, 0.96), rgba(37, 99, 235, 0.94));
            box-shadow: 0 30px 90px rgba(16, 42, 114, 0.26);
            color: white;
            overflow: hidden;
            isolation: isolate;
        }

        .panel-art::before {
            content: '';
            position: absolute;
            inset: 24px;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .panel-glow {
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.09);
            filter: blur(1px);
        }

        .glow-1 {
            width: 240px;
            height: 240px;
            right: -42px;
            top: -42px;
        }

        .glow-2 {
            width: 180px;
            height: 180px;
            left: -42px;
            bottom: 56px;
        }

        .glow-3 {
            width: 120px;
            height: 120px;
            right: 28px;
            bottom: 24px;
            background: rgba(255, 255, 255, 0.14);
        }

        .art-stack {
            position: absolute;
            inset: 0;
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .art-card {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 20px;
        }

        .art-kpi {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .kpi {
            background: rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            padding: 18px;
        }

        .kpi strong {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            line-height: 1;
            margin-bottom: 8px;
        }

        .kpi span {
            color: rgba(255, 255, 255, 0.78);
        }

        .floating-job {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-job .job-title {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
        }

        .tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .section {
            padding: 34px 0 88px;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 24px;
        }

        .section-head h2 {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            letter-spacing: -0.04em;
            color: var(--navy-950);
        }

        .section-head p {
            margin: 10px 0 0;
            color: var(--muted);
            max-width: 620px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .feature-card,
        .job-card,
        .cta-card {
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(16, 42, 114, 0.10);
            border-radius: 28px;
            box-shadow: 0 18px 44px rgba(16, 42, 114, 0.08);
        }

        .feature-card {
            padding: 24px;
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            color: var(--white);
            background: linear-gradient(135deg, var(--blue-600), var(--navy-900));
            margin-bottom: 18px;
            font-size: 1.2rem;
        }

        .feature-card h3,
        .job-card h3 {
            margin: 0 0 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            color: var(--navy-950);
        }

        .feature-card p,
        .job-card p,
        .cta-card p {
            color: var(--muted);
            line-height: 1.7;
            margin: 0;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 28px;
        }

        .stat {
            padding: 20px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.76);
            border: 1px solid rgba(16, 42, 114, 0.08);
        }

        .stat strong {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            color: var(--navy-950);
            margin-bottom: 6px;
        }

        .stat span {
            color: var(--muted);
        }

        .job-card { 
            padding: 24px; 
            display: flex; 
            flex-direction: column; 
            gap: 18px; 
        }

        .job-top { 
            display: flex; 
            justify-content: space-between; 
            gap: 16px; 
            align-items: start; 
        }

        .company {
            display: flex; 
            align-items: center; 
            gap: 10px; 
            color: var(--blue-600); 
            font-weight: 700; 
            margin-bottom: 14px;
        }

        .meta { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; 
            margin-bottom: 16px; 
        }

        .meta span {
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            padding: 8px 12px; 
            border-radius: 999px;
            background: rgba(224, 242, 254, 0.9); 
            color: var(--navy-900); 
            font-weight: 600; 
            font-size: 0.92rem;
        }

        .job-actions {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            gap: 16px; 
            padding-top: 8px;
            border-top: 1px solid rgba(16, 42, 114, 0.10);
        }

        .ghost-icon {
            width: 44px; 
            height: 44px; 
            border-radius: 14px; 
            border: 1px solid rgba(16, 42, 114, 0.12);
            background: rgba(255, 255, 255, 0.92); 
            display: grid; 
            place-items: center; 
            color: var(--navy-900);
        }

        .cta-wrap { 
            padding-bottom: 88px; 
        }

        .cta-card {
            padding: 34px; 
            background: linear-gradient(135deg, rgba(16, 42, 114, 0.98), rgba(37, 99, 235, 0.92));
            color: var(--white); 
            overflow: hidden; 
            position: relative;
        }

        .cta-card::after {
            content: ''; 
            position: absolute; 
            right: -80px; 
            top: -80px; 
            width: 260px; 
            height: 260px;
            border-radius: 999px; 
            background: rgba(255, 255, 255, 0.10);
        }

        .cta-card h2 {
            margin: 0 0 12px; 
            font-family: 'Poppins', sans-serif; 
            font-size: clamp(2rem, 4vw, 3.2rem);
            letter-spacing: -0.05em; 
            color: var(--white); 
            position: relative; 
            z-index: 1;
        }

        .cta-actions {
            display: flex; 
            flex-wrap: wrap; 
            gap: 14px; 
            margin-top: 24px; 
            position: relative; 
            z-index: 1;
        }

        .button-light { 
            background: var(--white); 
            color: var(--navy-900); 
            border-color: rgba(255, 255, 255, 0.22); 
        }

        .footer { 
            padding: 24px 0 40px; 
            color: var(--muted); 
            font-size: 0.95rem; 
        }

        @media (max-width: 1080px) {
            .hero-grid,
            .grid-3,
            .stats-row,
            .search-form { grid-template-columns: 1fr 1fr; }
            .panel-art { min-height: 480px; }
            .search-form .button { grid-column: span 2; }
        }

        @media (max-width: 760px) {
            .nav,
            .section-head,
            .job-top,
            .job-actions { flex-direction: column; align-items: stretch; }
            .nav-links { display: none; }
            .hero { padding-top: 56px; }
            .hero-grid,
            .grid-3,
            .stats-row,
            .search-form { grid-template-columns: 1fr; }
            .nav-actions,
            .hero-actions,
            .cta-actions { width: 100%; }
            .nav-actions .button,
            .hero-actions .button,
            .cta-actions .button { width: 100%; }
            .panel-art { min-height: 420px; }
            .search-form .button { grid-column: auto; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="shell nav">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark"><i class="bi bi-briefcase-fill"></i></span>
                ApplyHub
            </a>
            <nav class="nav-links" aria-label="Primary">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('jobs.public') }}">Jobs</a>
            </nav>
            <div class="nav-actions">
                <a class="button button-ghost" href="{{ url('/login') }}">Sign In</a>
                <a class="button button-primary" href="{{ route('jobs.public') }}">Browse Jobs</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="shell hero-grid">
                <div>
                    <div class="eyebrow"><i class="bi bi-stars"></i> Modern hiring, simplified</div>
                    <h1>Find your next role</h1>
                    <p>Search curated opportunities, review featured listings, and jump straight into the board</p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="{{ route('jobs.public') }}"><i class="bi bi-search"></i> Start Browsing</a>
                        <a class="button button-ghost" href="{{ url('/register') }}"><i class="bi bi-person-plus"></i> Create Account</a>
                    </div>

                    <div class="search-panel">
                        <form class="search-form" action="{{ route('jobs.public') }}" method="GET">
                            <label class="field" aria-label="Search jobs">
                                <i class="bi bi-search"></i>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search jobs, companies, or skills">
                            </label>
                            <label class="field" aria-label="Location">
                                <i class="bi bi-geo-alt-fill"></i>
                                <input type="text" name="location" value="{{ request('location') }}" placeholder="Manila, Remote, Cebu">
                            </label>
                            <label class="field" aria-label="Job type">
                                <i class="bi bi-funnel-fill"></i>
                                <select name="type">
                                    <option value="">All roles</option>
                                    <option value="full-time" {{ request('type') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ request('type') === 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ request('type') === 'contract' ? 'selected' : '' }}>Contractual</option>
                                    <option value="internship" {{ request('type') === 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </label>
                            <button class="button button-primary" type="submit"><i class="bi bi-arrow-right-circle"></i> Search</button>
                        </form>
                    </div>
                </div>

                <aside class="panel-art" aria-label="Highlights panel">
                    <span class="panel-glow glow-1"></span>
                    <span class="panel-glow glow-2"></span>
                    <span class="panel-glow glow-3"></span>

                    <div class="art-stack">
                        <div class="art-card floating-job">
                            <div class="company" style="color:#dbeafe; margin:0;"><i class="bi bi-building"></i> Featured opening</div>
                            <h3 class="job-title" style="color:#fff; font-size:1.55rem;">Senior Laravel Developer</h3>
                            <p style="color:rgba(255,255,255,.82);">Build high-performance hiring tools and refine a polished application experience for modern teams.</p>
                            <div class="tag-row">
                                <span class="tag"><i class="bi bi-geo-alt-fill"></i> Remote</span>
                                <span class="tag"><i class="bi bi-briefcase-fill"></i> Full-time</span>
                                <span class="tag"><i class="bi bi-cash-stack"></i> Competitive</span>
                            </div>
                        </div>

                        <div class="art-card">
                            <div class="art-kpi">
                                <div class="kpi"><strong>250+</strong><span>active listings</span></div>
                                <div class="kpi"><strong>48h</strong><span>average response</span></div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        

        <section class="cta-wrap">
            <div class="shell">
                <div class="cta-card">
                    <h2>Ready to jump into the board?</h2>
                    <div class="cta-actions">
                        <a class="button button-primary" href="{{ route('jobs.public') }}" style="padding:14px 22px;font-size:16px"><i class="bi bi-arrow-right"></i> Start Browsing</a>
                        <a class="button button-ghost" href="{{ url('/login') }}" style="color: #fff; border-color: rgba(255,255,255,.22); background: rgba(255,255,255,.10);padding:12px 18px"><i class="bi bi-person-circle"></i> Sign In</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="shell">
            <div>ApplyHub • Landing page for the job board.</div>
        </div>
    </footer>
</body>
</html>
