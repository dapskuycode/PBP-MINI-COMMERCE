<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminFromUserPages
{
    /**
     * Handle an incoming request.
     * Redirect admin users to dashboard if they try to access user/buyer pages.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is admin
        if (auth()->check() && auth()->user()->is_admin) {
            // Redirect admin to dashboard with a warning message
            return redirect()->route('dashboard')
                ->with('warning', 'Akses ditolak. Admin tidak diperkenankan mengakses halaman tersebut.');
        }

        return $next($request);
    }
}
