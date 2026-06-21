<!--
The main layout file containing your HTML head, CSS/JS links, 
and a dynamic navigation bar that changes based on Auth::user()->role
-->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','JobPortal')</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
  :root{
    --rb-900:#0b1e57; --rb-700:#1e3a8a; --rb-600:#1d4ed8; --rb-500:#2563eb; --rb-50:#eff6ff;
    --white:#fff; --ink:#0f172a; --muted:#64748b; --line:#e5e7eb;
    --ok:#16a34a; --warn:#d97706; --bad:#dc2626;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Inter',sans-serif;font-size:15px;color:var(--ink);background:#f8fafc;line-height:1.6}
  h1,h2,h3,h4{font-family:'Poppins',sans-serif;color:var(--rb-900)}
  a{text-decoration:none;color:inherit}

  .nav{background:var(--rb-700);color:#fff;padding:14px 40px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 8px rgba(0,0,0,.08)}
  .nav .logo{font-family:'Poppins';font-weight:700;font-size:25px;color:#fff}
  .nav ul{display:flex;gap:28px;list-style:none}
  .nav ul a{font-size:22px;font-weight:700;color:#e0e7ff}
  .nav ul a:hover{color:#fff}
  .nav .cta{background:#fff;color:var(--rb-700);padding:8px 18px;border-radius:30px;font-weight:600;font-size:18px}

  .wrap{max-width:1200px;margin:0 auto;padding:40px 24px}

  .card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:22px;box-shadow:0 1px 3px rgba(15,23,42,.04)}
  .btn{display:inline-block;padding:10px 20px;border-radius:30px;font-size:14px;font-weight:600;cursor:pointer;border:none;transition:.2s}
  .btn-primary{background:var(--rb-700);color:#fff}
  .btn-primary:hover{background:var(--rb-900)}
  .btn-outline{background:#fff;color:var(--rb-700);border:1.5px solid var(--rb-700)}
  .btn-danger{background:var(--bad);color:#fff}
  .btn-success{background:var(--ok);color:#fff}

  .pill{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
  .pill-pending{background:#fef3c7;color:var(--warn)}
  .pill-accepted{background:#dcfce7;color:var(--ok)}
  .pill-rejected{background:#fee2e2;color:var(--bad)}

  table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden}
  th{background:var(--rb-50);color:var(--rb-700);text-align:left;padding:14px;font-size:13px;text-transform:uppercase;letter-spacing:.5px}
  td{padding:14px;border-top:1px solid var(--line);font-size:14px}

  input,select,textarea{width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:8px;font-family:inherit;font-size:14px;outline:none}
  input:focus,select:focus,textarea:focus{border-color:var(--rb-500);box-shadow:0 0 0 3px rgba(37,99,235,.15)}
  label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--ink)}

  .tabs{display:flex;gap:8px;border-bottom:2px solid var(--line);margin-bottom:24px}
  .tabs a{padding:12px 22px;font-weight:600;color:var(--muted);border-bottom:3px solid transparent;margin-bottom:-2px}
  .tabs a.active{color:var(--rb-700);border-color:var(--rb-700)}
</style>
</head>
<body>

<nav class="nav">
  <div class="logo">Good Job 8</div>
  <ul>
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ route('jobs.index') }}">Jobs</a></li>
    <li><a href="{{ url('/applications') }}">Applications</a></li>
    <li><a href="{{ url('/profile') }}">Profile</a></li>
  </ul>
  <a href="{{ url('/login') }}" class="cta">Get Started</a>
</nav>

@yield('content')

</body>
</html>
