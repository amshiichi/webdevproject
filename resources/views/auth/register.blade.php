<!--
The register / sign-up form
-->

@extends('layouts.app')

@section('content')
    <div>Placeholder Register Header</div>

    @if ($errors->any())
        <div style="color: red; border: 2px solid red; padding: 10px;">
            <strong>Validation Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div>Name Input Text Placeholder: <input type="text" name="name"></div>
        <div>Email Input Text Placeholder: <input type="text" name="email"></div>
        <div>Role Dropdown Placeholder: 
            <select name="role">
                <option value="applicant">Applicant Option Placeholder</option>
                <option value="employer">Employer Option Placeholder</option>
            </select>
        </div>
        <div>Password Input Text Placeholder: <input type="password" name="password"></div>
        <div>Confirm Password Input Text Placeholder: <input type="password" name="password_confirmation"></div>   
        <input type="submit" value="Submit Button Placeholder">
    </form>
@endsection