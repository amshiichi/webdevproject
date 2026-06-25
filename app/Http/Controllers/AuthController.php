<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller
{
    public function showLogin(){
        if(Auth::check()){
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $remember = $request->boolean('remember');
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)){
            return back()->withErrors([
                'email' => 'The provided credentials do not match system records.'
            ])->onlyInput('email');
        }
        $request->session()->regenerate();
        $user = Auth::user();
        session(['account_role' => $user->role]);
        if($user->role === 'admin'){
            return redirect()->route('admin.dashboard');
        } elseif($user->role === 'employer'){
            return redirect()->route('employer.home');
        } else {
            return redirect()->route('jobs.index');
        }
    }

    public function showRegister(){
        if(Auth::check()){
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'role' => ['required', 'in:applicant,employer'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['required', 'accepted']
        ]);
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_status' => $request->role === 'employer' ? 'pending' : 'approved'
        ]);
        Auth::login($user);
        session(['account_role' => $request->role]);
        return $request->role === 'employer' ? redirect()->route('employer.home') : redirect()->route('jobs.index');
    }

    private function redirectByRole($user){
        if($user->role === 'admin'){
            return redirect()->route('admin.dashboard');
        } elseif($user->role === 'employer'){
            return redirect()->route('employer.home');
        } else {
            return redirect()->route('jobs.index');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        session()->forget('account_role');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
