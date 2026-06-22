<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Handles Login, Registration, and Logout for all users.

    public function showLogin(){
        return view('auth.login');
    
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
        }

        $user = Auth::user();
        if($user->role === 'employer'){
            session(['account_role' => 'employer']);
            return redirect()->route('employer.home');
        }else{
            session(['account_role' => 'applicant']);
            return redirect()->route('jobs.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match system records.'
        ])->onlyInput('email');
    }
        

    public function showRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'role' => ['required', 'in:applicant,employer'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)]
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        Auth::login($user);
        session(['account_role' => $validated['role']]);
        return $validated['role'] === 'employer'
            ? redirect()->route('employer.home')
            : redirect()->route('jobs.index');
    }

    public function logout(Request $request){
        Auth::logout();

        session()->forget('account_role');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}