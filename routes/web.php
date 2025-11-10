<?php

// routes/web.php (KODE FINAL)

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\OrderController; // <-- BARIS INI HARUS AKTIF!
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Models\Game;
// --- A. ROUTE PUBLIK (FRONTEND USER) ---

// Homepage / Landing Page
Route::get('/', function () {
    $games = Game::where('is_active', true)->orderBy('name')->get(); 
    return view('index', compact('games'));
})->name('homepage');

// Halaman Detail Top Up (Input Order)
Route::get('/topup/{game:slug}', [GameDetailController::class, 'show'])->name('topup.show');

// Proses Order dan Konfirmasi Pembayaran
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{invoice_number}/confirm', [OrderController::class, 'confirmation'])->name('order.confirmation');


// --- B. ROUTE TERPROTEKSI DASAR (User Biasa & Admin Profile) ---

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Jika user adalah Admin, paksa redirect ke Panel Admin
        if (Auth::user()->role === 1) {
            return redirect()->route('admin.dashboard');
        }
        // Jika user adalah user biasa (role 0), tampilkan dashboard user
        return view('dashboard'); 
    })->name('dashboard');Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/orders/history', [OrderController::class, 'userHistory'])->name('user.orders.history');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- C. ROUTE ADMIN (Khusus role=1) ---

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    
    // Dashboard Admin (Landing page untuk /admin)
    Route::get('/', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard'); 
    
    // 1. Management Game
    Route::resource('games', GameController::class);
    
    // 2. Management Nominal Top Up
    Route::resource('products', ProductController::class);
    
    // 3. Management Pesanan (Hanya Index, Show, dan Update Status)
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']); 
});

require __DIR__.'/auth.php';