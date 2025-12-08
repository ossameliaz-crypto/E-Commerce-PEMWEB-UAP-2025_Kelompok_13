<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (MASTER - FINAL FIXED FLOW)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. CUSTOMER SIDE (HALAMAN PEMBELI)
// ==========================================

// Homepage
Route::get('/', function () { return view('welcome'); })->name('home');

// Workshop & Inventory (Diasumsikan hanya menampilkan view)
Route::get('/workshop', function () { return view('builder'); })->name('workshop');
Route::get('/wardrobe', function () { return view('wardrobe'); })->name('wardrobe');

// Checkout, Payment, History (Membutuhkan autentikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/payment', function () { return view('payment'); })->name('payment');
    Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
    Route::get('/history', function () { return view('history'); })->name('history');

    // Logic Cart
    Route::post('/cart/add-custom', function () { 
        return redirect()->route('checkout'); 
    })->name('cart.add-custom');
});


// ==========================================
// 2. SELLER SIDE (HALAMAN PENJUAL)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // GET: Menampilkan formulir pendaftaran Toko.
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');

    // POST: Memproses pendaftaran, INSERT data (termasuk sinkronisasi logo).
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create'); 

    // Area Seller: Asumsi kamu akan menggunakan Middleware 'role:seller' (atau sejenisnya)
    Route::prefix('seller')->name('seller.')->group(function () {
        // Catatan: Jika Anda punya middleware 'role:seller', tambahkan di sini.

        // Dashboard Utama Seller (GET)
        Route::get('/dashboard', function () { return view('seller.dashboard'); })->name('dashboard');

        // Manajemen Produk (Upload)
        Route::get('/products/create', function () { return view('seller.products.create'); })->name('products.create');

        // Pesanan Masuk
        Route::get('/orders', function () { return view('seller.orders'); })->name('orders');

        // Dompet & Penarikan Saldo
        Route::get('/withdrawals', function () { return view('seller.withdrawals'); })->name('withdrawals');
    });
});


// ==========================================
// 3. ADMIN SIDE (HALAMAN ADMIN)
// ==========================================

// Harus dilindungi oleh middleware role 'admin' 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
});


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
    Route::patch('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image'); 
});


// Load file auth bawaan (Login/Register logic)
require __DIR__.'/auth.php';