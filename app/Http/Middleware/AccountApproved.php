<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        $user = $request->user();

        if ($user && $user->account_status !== 'approved'){
            $message = $user->account_status === 'pending' ? 'Your employer account is awaiting admin approval.'
                                                           : 'Your account has been suspended. Please contact support.';

            Auth::logout();
            $request->session()->invalidate();

            return redirect()->route('login')->withErrors(['email' => $message]);
        }
        
        return $next($request);
    }
}
