<!--
A single, tabbed page for managing the job queue and flagged items.
-->
@extends('layouts.app')
@section('title', 'Admin Moderation')
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

    .admin-wrapper {
        max-width: 1400px;
        margin: 80px auto 120px auto; 
        padding: 0 40px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .page-title {
        font-size: 48px; 
        font-weight: 800;
        color: var(--royal-blue-deep);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 20px; 
        color: var(--royal-blue-main);
        margin-bottom: 48px;
        font-weight: 500;
    }

    .admin-tabs-container {
        display: flex;
        gap: 24px;
        margin-bottom: 44px;
        border-bottom: 4px solid var(--royal-blue-light); 
    }

    .admin-tab-link {
        font-size: 22px;
        font-weight: 700;
        color: var(--royal-blue-main);
        padding: 20px 40px;
        text-decoration: none;
        border-bottom: 4px solid transparent;
        margin-bottom: -4px;
        transition: all 0.2s ease;
    }

    .admin-tab-link:hover {
        color: var(--royal-blue-bright);
    }

    .admin-tab-link.active {
        color: var(--royal-blue-bright);
        border-bottom-color: var(--royal-blue-bright);
    }

    .table-container {
        background: var(--pure-white);
        border: 2px solid var(--royal-blue-light);
        border-radius: 28px; 
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(30, 64, 175, 0.04);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 21px; 
    }

    .custom-table th {
        background: var(--royal-blue-light);
        color: var(--royal-blue-deep);
        font-weight: 700;
        padding: 32px 44px; 
        border-bottom: 2px solid var(--royal-blue-tint);
        text-transform: uppercase;
        font-size: 16px; 
        letter-spacing: 0.8px;
    }

    .custom-table td {
        padding: 38px 44px; 
        color: var(--royal-blue-deep);
        border-bottom: 2px solid var(--royal-blue-light);
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .primary-cell-text {
        font-size: 24px;
        font-weight: 700;
        color: var(--royal-blue-deep);
    }

    .secondary-cell-text {
        font-size: 21px; 
        font-weight: 500;
        color: var(--royal-blue-main);
    }

    .metric-cell-text {
        font-size: 24px; 
        font-weight: 600;
        color: var(--royal-blue-deep);
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px; 
        border-radius: 12px;
        font-size: 16px; 
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pill.pill-pending {
        background: var(--royal-blue-light);
        color: var(--royal-blue-bright);
        border: 2px solid var(--royal-blue-tint);
    }

    .status-pill.pill-active {
        background: var(--royal-blue-main);
        color: var(--pure-white);
    }

    .action-button-group {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .btn-admin-primary {
        background: var(--royal-blue-bright);
        color: var(--pure-white);
        font-weight: 600;
        font-size: 18px; 
        padding: 14px 34px;
        border-radius: 14px;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-admin-primary:hover {
        background: var(--royal-blue-main);
        transform: translateY(-1px);
    }

    .btn-admin-severe {
        background: transparent;
        color: var(--royal-blue-deep);
        border: 2px solid var(--royal-blue-tint);
        font-weight: 600;
        font-size: 18px; 
        padding: 12px 32px;
        border-radius: 14px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-admin-severe:hover {
        background: var(--royal-blue-light);
        border-color: var(--royal-blue-deep);
    }

    .btn-admin-outline {
        background: transparent;
        color: var(--royal-blue-bright);
        border: 2px solid var(--royal-blue-bright);
        font-weight: 600;
        font-size: 18px;
        padding: 12px 32px;
        border-radius: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-admin-outline:hover {
        background: var(--royal-blue-light);
    }
</style>

<div class="admin-wrapper">
    <h1 class="page-title">Admin Moderation</h1>
    <p class="page-subtitle">Review and moderate employers and applicants</p>

    {{-- TABS --}}
    <div class="admin-tabs-container">
        <a href="?tab=employers" class="admin-tab-link {{ request('tab', 'employers') == 'employers' ? 'active' : '' }}">
            Employers
        </a>
        <a href="?tab=applicants" class="admin-tab-link {{ request('tab') == 'applicants' ? 'active' : '' }}">
            Applicants
        </a>
    </div>

    @if(request('tab', 'employers') == 'employers')
        {{-- EMPLOYERS PANEL --}}
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Jobs Posted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($employers as $emp) --}}
                    <tr>
                        <td class="primary-cell-text">TechCorp Inc.</td>
                        <td class="secondary-cell-text">hr@techcorp.com</td>
                        {{-- Before: <td style="font-weight: 600;">14</td> --}}
                        <td class="metric-cell-text">14</td>
                        <td>
                            <span class="status-pill pill-pending">Pending</span>
                        </td>
                        <td>
                            <div class="action-button-group">
                                <button class="btn-admin-primary">Approve</button>
                                <button class="btn-admin-severe">Reject</button>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    @else
        {{-- APPLICANTS PANEL --}}
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Applications</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($applicants as $app) --}}
                    <tr>
                        <td class="primary-cell-text">Juan Dela Cruz</td>
                        <td class="secondary-cell-text">juan@email.com</td>
                        {{-- Before: <td style="font-weight: 600;">7</td> --}}
                        <td class="metric-cell-text">7</td>
                        <td>
                            <span class="status-pill pill-active">Active</span>
                        </td>
                        <td>
                            <div class="action-button-group">
                                <a href="#" class="btn-admin-outline">View</a>
                                <button class="btn-admin-severe">Suspend</button>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection