<?php

// routes/web.php (KODE FINAL DAN PERBAIKAN)

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Models\Game;

// --- A. ROUTE PUBLIK (FRONTEND USER) ---

// Homepage / Landing Page
Route::get('/', function () {
    // (Mock data dihilangkan untuk finalisasi - gunakan query DB)
    $games = Game::all(); 
    return view('index', compact('games'));
})->name('homepage');

// Halaman Detail Top Up (Input Order)
Route::get('/topup/{game:slug}', [GameDetailController::class, 'show'])->name('topup.show');

// Proses Order dan Konfirmasi Pembayaran
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// ORDER STATUS VIEW (Fix: Menggunakan Controller method yang benar)
Route::get('/order/{invoice_number}/status', [OrderController::class, 'confirmation'])->name('order.status.view');


// --- B. ROUTE TERPROTEKSI DASAR (User Biasa & Admin Profile) ---

Route::middleware('auth')->group(function () {
    
    // 1. Dashboard Logic
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); 
    })->name('dashboard');
    
    // 2. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 3. Order History
    Route::get('/orders/history', [OrderController::class, 'userHistory'])->name('user.orders.history');
});


// --- C. ROUTE ADMIN (Khusus role=1) ---

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', function () { return view('admin.dashboard'); })->name('admin.dashboard'); 
    Route::resource('games', GameController::class);
Route::resource('products', ProductController::class);// Menggunakan alias Controller
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']); 
});

require __DIR__.'/auth.php';