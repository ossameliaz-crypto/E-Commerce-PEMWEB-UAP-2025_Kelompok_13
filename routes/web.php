<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (MASTER - FINAL FIXED FLOW)
|--------------------------------------------------------------------------
|
| Ini adalah file rute lengkap untuk seluruh aplikasi Build-A-Teddy.
| Alur: Workshop -> Checkout -> Payment -> History
|
*/

// ==========================================
// 1. CUSTOMER SIDE (HALAMAN PEMBELI)
// ==========================================

// Homepage
Route::get('/', function () { return view('welcome'); })->name('home');

// Workshop (Buat Boneka)
Route::get('/workshop', function () { return view('builder'); })->name('workshop');

// Lemari Saya (Inventory)
Route::get('/wardrobe', function () { return view('wardrobe'); })->name('wardrobe');

// Pembayaran & Checkout
Route::get('/payment', function () { return view('payment'); })->name('payment');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');

// Riwayat Pesanan (Lacak Paket)
Route::get('/history', function () { return view('history'); })->name('history');

// [FIX] Logic Cart: Redirect ke Checkout dulu (Bukan langsung Payment)
Route::post('/cart/add-custom', function () { 
    return redirect()->route('checkout'); 
})->name('cart.add-custom');


// ==========================================
// 2. SELLER SIDE (HALAMAN PENJUAL)
// ==========================================

// Pendaftaran Toko
Route::get('/store/register', function () { return view('seller.register'); })->name('store.register');
Route::post('/store/create', function () { return redirect()->route('seller.dashboard'); })->name('store.create');

// Dashboard Utama Seller
Route::get('/seller/dashboard', function () { return view('seller.dashboard'); })->name('seller.dashboard');

// Manajemen Produk (Upload)
Route::get('/seller/products/create', function () { return view('seller.products.create'); })->name('seller.products.create');

// Pesanan Masuk
Route::get('/seller/orders', function () { return view('seller.orders'); })->name('seller.orders');

// Dompet & Penarikan Saldo
Route::get('/seller/withdrawals', function () { return view('seller.withdrawls'); })->name('seller.withdrawals');


// ==========================================
// 3. ADMIN SIDE (HALAMAN ADMIN)
// ==========================================

// Dashboard Admin
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');


// ==========================================
// 4. AUTHENTICATION & USER PROFILE (DEFAULT LARAVEL)
// ==========================================

// Dashboard User Biasa (Setelah Login)
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// Profil User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load file auth bawaan (Login/Register logic)
require __DIR__.'/auth.php';