<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Handles Login, Registration, and Logout for all users.

    public function showLogin() { return view('auth.login'); }
    public function login(Request $request)
    {
        $role = $request->input('role', 'applicant');
        session(['account_role' => $role]);

        return $role === 'employer'
            ? redirect()->route('employer.home')
            : redirect()->route('jobs.index');
    }
    public function showRegister() { return view('auth.register'); }
    public function register(Request $request)
    {
        $role = $request->input('role', 'applicant');
        session(['account_role' => $role]);

        return $role === 'employer'
            ? redirect()->route('employer.home')
            : redirect()->route('jobs.index');
    }
    public function logout()
    {
        session()->forget('account_role');

        return redirect()->route('login');
    }
}