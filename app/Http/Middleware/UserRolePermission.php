<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response{
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Forbidden: You are not authorized to access this page.');
        }

        if ($user->role === 'admin' && !in_array('admin', $roles)) {
            abort(403, 'Forbidden: Admins cannot access this page.');
        }

        return $next($request);
    }
}
