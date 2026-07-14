<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $userRole = Auth::user()->role;

        // Admin (role = 1) được truy cập toàn hệ thống
        if ($userRole == 1) {
            return $next($request);
        }

        if (!in_array($userRole, $roles)) {
            abort(403, "Bạn không có quyền truy cập");
        }
        
        return $next($request);
    }
}
