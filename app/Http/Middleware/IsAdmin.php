<?php

// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ganti auth()->check() menjadi Auth::check()
        // Ganti auth()->user()->role menjadi Auth::user()->role
        if (Auth::check() && Auth::user()->role == 1) { 
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses Ditolak. Anda bukan Admin.');
    }
}