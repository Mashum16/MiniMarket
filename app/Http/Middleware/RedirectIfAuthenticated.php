<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Kalau sudah login, arahkan berdasarkan role
            $role = Auth::user()->role;

            if ($role === 'admin') return redirect('admin');
            if ($role === 'staff') return redirect('staff');
            return redirect('/beranda');
        }

        return $next($request);
    }
}
