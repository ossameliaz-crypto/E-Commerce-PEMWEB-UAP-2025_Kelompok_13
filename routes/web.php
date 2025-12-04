<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (MASTER FILE)
|--------------------------------------------------------------------------
|
| Ini adalah file rute lengkap untuk seluruh aplikasi Build-A-Teddy.
| Semua halaman didaftarkan di sini.
|
*/

// ==========================================
// 1. HALAMAN PUBLIK (Customer)
// ==========================================

// Homepage (Beranda)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Workshop (Buat Boneka + Suara)
Route::get('/workshop', function () {
    return view('builder');
})->name('workshop');

// Lemari Saya (Inventory)
Route::get('/wardrobe', function () {
    return view('wardrobe');
})->name('wardrobe');

// Halaman Pembayaran (Tantangan Ujian)
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

// Simulasi Masuk Keranjang (Redirect ke Payment)
Route::post('/cart/add-custom', function () {
    return redirect()->route('payment'); 
})->name('cart.add-custom');


// ==========================================
// 2. HALAMAN SELLER (Tantangan II)
// ==========================================

// Form Daftar Toko
Route::get('/store/register', function () {
    return view('seller.register');
})->name('store.register');

// Proses Simpan Toko (Dummy Redirect)
Route::post('/store/create', function () {
    return redirect()->route('seller.dashboard'); 
})->name('store.create');

// Dashboard Penjual
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->name('seller.dashboard');


// ==========================================
// 3. HALAMAN ADMIN (Tantangan III)
// ==========================================

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


// ==========================================
// 4. HALAMAN AUTH & USER (Bawaan Laravel)
// ==========================================

// Dashboard User Biasa (Setelah Login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load file auth bawaan (Login/Register logic)
// PENTING: Jangan dihapus, ini biar halaman /login dan /register bisa dibuka
require __DIR__.'/auth.php';