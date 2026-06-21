<!--
A polymorphic list.
If logged in as an applicant, it shows "My Applications". If logged in as an employer, it shows "Received Applications".
-->
@extends('layouts.app')
@section('title', 'My Applications')
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

    .app-wrapper {
        max-width: 1300px;
        margin: 60px auto 100px auto;
        padding: 0 32px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .page-title {
        font-size: 42px;
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 18px;
        color: var(--royal-blue-main);
        margin-bottom: 44px;
        font-weight: 500;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 48px;
    }

    .stat-card {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(30, 64, 175, 0.02);
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card.total { border-left: 6px solid var(--royal-blue-deep); }
    .stat-card.pending { border-left: 6px solid var(--royal-blue-bright); }
    .stat-card.accepted { border-left: 6px solid var(--royal-blue-main); background: var(--royal-blue-light); }
    .stat-card.rejected { border-left: 6px solid var(--royal-blue-tint); }

    .stat-label {
        color: var(--royal-blue-main);
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .stat-number {
        font-size: 42px;
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin: 0;
    }

    .table-container {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(30, 64, 175, 0.03);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 19px;
    }

    .custom-table th {
        background: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        font-weight: 700;
        padding: 28px 36px;
        border-bottom: 2px solid var(--royal-blue-tint);
        text-transform: uppercase;
        font-size: 16px;
        letter-spacing: 0.5px;
    }

    .custom-table td {
        padding: 34px 36px;
        color: var(--royal-blue-deep);
        border-bottom: 2px solid var(--royal-blue-light);
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .job-title-cell {
        font-size: 21px;
        font-weight: 700;
        color: var(--royal-blue-deep);
    }

    .company-cell {
        font-weight: 500;
        color: var(--royal-blue-main);
    }

   .status-pill {
    display: inline-flex;
    align-items: center;
    padding: 10px 24px; 
    border-radius: 10px;
    font-size: 15px; 
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    }

    .status-pill.pill-pending {
        background: var(--royal-blue-light);
        color: var(--royal-blue-bright);
        border: 2px solid var(--royal-blue-tint);
    }

    .status-pill.pill-accepted {
        background: var(--royal-blue-main);
        color: var(--pure-white);
    }

    .status-pill.pill-rejected {
        background: var(--pure-white);
        color: rgba(15, 30, 70, 0.45);
        border: 2px solid var(--royal-blue-light);
    }

    .btn-royal-outline {
    background: transparent;
    color: var(--royal-blue-bright);
    border: 2px solid var(--royal-blue-bright);
    font-weight: 600;
    font-size: 16px; 
    padding: 12px 32px; 
    border-radius: 12px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
    }

    .btn-royal-outline:hover {
        background: var(--royal-blue-light);
        color: var(--royal-blue-main);
    }
</style>

<div class="app-wrapper">
    <h1 class="page-title">Application Tracking</h1>
    <p class="page-subtitle">Monitor the status of all your job applications</p>

    {{-- STAT CARDS --}}
     <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px">
    <div class="card" style="border-left:4px solid var(--rb-700)">
      <p style="color:var(--muted);font-size:18px">TOTAL</p>
      <h2 style="font-size:32px">12</h2>
    </div>
    <div class="card" style="border-left:4px solid var(--warn)">
      <p style="color:var(--muted);font-size:18px">PENDING</p>
      <h2 style="font-size:32px">5</h2>
    </div>
    <div class="card" style="border-left:4px solid var(--ok)">
      <p style="color:var(--muted);font-size:18px">ACCEPTED</p>
      <h2 style="font-size:32px">4</h2>
    </div>
    <div class="card" style="border-left:4px solid var(--bad)">
      <p style="color:var(--muted);font-size:18px">REJECTED</p>
      <h2 style="font-size:32px">3</h2>
    </div>
  </div>

    {{-- TABLE --}}
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Applied On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($applications as $app) --}}
                <tr>
                    <td class="job-title-cell">Frontend Developer</td>
                    <td class="company-cell">TechCorp</td>
                    <td style="opacity: 0.85;">Jun 10, 2026</td>
                    <td>
                        <span class="status-pill pill-pending">Pending</span>
                    </td>
                    <td>
                        <a href="#" class="btn-royal-outline">View</a>
                    </td>
                </tr>
                <tr>
                    <td class="job-title-cell">UI Designer</td>
                    <td class="company-cell">Designly</td>
                    <td style="opacity: 0.85;">Jun 05, 2026</td>
                    <td>
                        <span class="status-pill pill-accepted">Accepted</span>
                    </td>
                    <td>
                        <a href="#" class="btn-royal-outline">View</a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection



