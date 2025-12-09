<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use App\Http\Controllers\ProductController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (FINAL VERSION)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. CUSTOMER SIDE (HALAMAN PEMBELI)
// ==========================================

Route::get('/', function () { return view('welcome'); })->name('home');
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

// Pendaftaran Toko: Semua user terautentikasi bisa mengakses
Route::middleware(['auth'])->group(function () {
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store', [StoreController::class, 'store'])->name('store.create'); 
});


// Area Seller: Harus memiliki role 'seller'
// 🛑 PERBAIKAN: Menggunakan alias 'role:seller' (sesuai pendaftaran di bootstrap/app.php)
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    
    // Dashboard Utama Seller
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // Manajemen Produk (CRUD Lengkap)
    // Rute: /seller/products, /seller/products/create, dll.
    Route::resource('products', ProductController::class)->except(['show']); 
    
    // Pesanan Masuk
    Route::get('/orders', function () { return view('seller.orders'); })->name('orders');

    // Dompet & Penarikan Saldo
    Route::get('/withdrawals', function () { return view('seller.withdrawals'); })->name('withdrawals');
});


// ==========================================
// 3. ADMIN SIDE (HALAMAN ADMIN)
// ==========================================

// Harus dilindungi oleh middleware role 'admin' 
// 🛑 PERBAIKAN: Menggunakan alias 'role:admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
});


// ==========================================
// 4. AUTHENTICATION & USER PROFILE 
// ==========================================

// Dashboard User Biasa (Setelah Login)
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// Profil User & Update
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image'); 
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});


// Load file auth bawaan (Login/Register logic)
// Pastikan file auth.php yang Anda tunjukkan sebelumnya TIDAK mengandung Route Resource produk yang duplikat
require __DIR__.'/auth.php';