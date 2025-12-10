<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use App\Http\Controllers\ProductController; // Digunakan untuk CRUD Produk
use App\Http\Controllers\CartController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

/*
|--------------------------------------------------------------------------
| Web Routes (MASTER - MERGED FRONTEND & BACKEND)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. CUSTOMER SIDE (HALAMAN PUBLIK)
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

    // Logika Pembeda Tombol: Beli Sekarang vs Masuk Keranjang
    Route::post('/cart/add-custom', function (Request $request) { 
        if ($request->input('action_type') == 'buy') {
            return redirect()->route('checkout'); 
        } else {
            return redirect()->route('wardrobe'); 
        }
    })->name('cart.add-custom');
});


// ==========================================
// 2. SELLER SIDE (HALAMAN PENJUAL)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // Registrasi Toko (GET & POST)
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create'); 

    // Area Seller: Harus memiliki role 'seller'
    Route::prefix('seller')->name('seller.')->group(function () {
        // Dashboard Utama Seller (GET)
        Route::get('/dashboard', function () { return view('seller.dashboard'); })->name('dashboard');

        // 🎯 PERBAIKAN KRUSIAL: Manajemen Produk (Resource Route)
        // Menggantikan Route::get('/products/create', ...)
        // Ini mendaftarkan seller.products.index, seller.products.create, dan seller.products.store (POST)
        Route::resource('products', ProductController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names('products');

        // Pesanan Masuk & Laporan
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

// Profil User & Update
Route::middleware('auth')->group(function () {
    // Profil Info, Update, Delete
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Update Foto Profil/Logo Toko 
    Route::patch('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image'); 

    // Route ini diperlukan untuk form Update Password di halaman profil
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});


// Load file auth bawaan (Login/Register logic)
require __DIR__.'/auth.php';