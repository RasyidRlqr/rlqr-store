<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    // 1. Validasi Input
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // 2. Lakukan Autentikasi Menggunakan Auth::attempt()
    if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        // Jika autentikasi gagal
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }
    
    // 3. Regenerate Session (Hanya jika autentikasi berhasil)
    $request->session()->regenerate();
    
    // --- LOGIKA REDIRECT FINAL (Sesuai role) ---
    if (Auth::user()->role === 1) {
        // Admin diarahkan ke Panel Admin
        return redirect()->intended('/admin'); 
    }

    // User biasa diarahkan ke Homepage
    return redirect()->intended('/'); 
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
