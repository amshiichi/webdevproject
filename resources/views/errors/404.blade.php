@extends('layouts.app')

@section('content')
<div class="error-container" style="text-align: center; padding: 50px;">
    <h1 style="font-size: 48px; margin-bottom: 20px;">404</h1>
    <h2 style="margin-bottom: 20px;">Page Not Found</h2>
    <p style="margin-bottom: 30px; font-size: 16px;">The page you are looking for could not be found.</p>
    @if(Auth::check())
        @if(Auth::user()->role === 'employer')
            <a href="{{ route('employer.home') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Go to Home</a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Go to Home</a>
        @else
            <a href="{{ route('jobs.index') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Go to Home</a>
        @endif
    @else
        <a href="{{ route('landing') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Go to Home</a>
    @endif
</div>
@endsection
