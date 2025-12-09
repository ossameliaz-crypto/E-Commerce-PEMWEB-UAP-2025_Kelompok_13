<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use App\Http\Controllers\CartController; // Tambahkan ini jika nanti Controller Cart sudah jadi
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // [PENTING] Tambahkan ini untuk menangkap input tombol

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

    // [FIXED] Logika Pembeda Tombol: Beli Sekarang vs Masuk Keranjang
    // Menangkap Data dari Workshop
    Route::post('/cart/add-custom', function (Request $request) { 
        // Cek tombol mana yang diklik user (dikirim via name="action_type")
        
        if ($request->input('action_type') == 'buy') {
            // Kalau klik 'Beli Sekarang' -> Langsung Checkout (Gas bayar)
            return redirect()->route('checkout'); 
        } else {
            // Kalau klik 'Masuk Keranjang' -> Ke Wardrobe (Lanjut belanja/mikir dulu)
            return redirect()->route('wardrobe'); 
        }
    })->name('cart.add-custom');
});


// ==========================================
// 2. SELLER SIDE (HALAMAN PENJUAL)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // GET: Menampilkan formulir pendaftaran Toko.
    // Kalau StoreController belum dibuat backend, ganti baris ini jadi: function() { return view('seller.register'); }
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');

    // POST: Memproses pendaftaran, INSERT data (termasuk sinkronisasi logo).
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create'); 

    // Area Seller: Harus memiliki role 'seller'
    Route::prefix('seller')->name('seller.')->group(function () {
        // Dashboard Utama Seller (GET)
        Route::get('/dashboard', function () { return view('seller.dashboard'); })->name('dashboard');

        // Manajemen Produk (Upload)
        Route::get('/products/create', function () { return view('seller.products.create'); })->name('products.create');

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