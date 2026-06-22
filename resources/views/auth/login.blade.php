<!--
The log-in / sign-in form
-->

@extends('layouts.app')

@section('content')
    <div>Placeholder Login Header</div>
    
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

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div>Email Input Text Placeholder: <input type="text" name="email"></div>
        <div>Password Input Text Placeholder: <input type="password" name="password"></div>
        <input type="submit" value="Submit Button Placeholder">
    </form>
@endsection