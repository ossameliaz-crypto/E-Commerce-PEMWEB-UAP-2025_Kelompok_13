<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; // WAJIB: Import StoreController
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (FINAL FIXED FLOW)
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

// Checkout, Payment, History 
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
    Route::get('/payment', function () { return view('payment'); })->name('payment');
    Route::get('/history', function () { return view('history'); })->name('history');
    
    // Logic Cart: Redirect ke Checkout dulu
    Route::post('/cart/add-custom', function () { 
        // Idealnya: [CartController::class, 'add']
        return redirect()->route('checkout'); 
    })->name('cart.add-custom');
});


// ==========================================
// 2. SELLER SIDE (HALAMAN PENJUAL)
// ==========================================

Route::middleware(['auth'])->group(function () {
    // PENDAFTARAN TOKO (Form Buka Toko)
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    
    // POST: Memproses pendaftaran toko, MENGUBAH ROLE user menjadi 'seller', dan INSERT data ke tabel 'stores'.
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create');


    // SELLER AREA (Hanya bisa diakses oleh user dengan role 'seller')
    Route::middleware(['role:seller'])->prefix('seller')->name('seller.')->group(function () {

        Route::get('/dashboard', function () { return view('seller.dashboard'); })->name('dashboard');
        Route::get('/products/create', function () { return view('seller.products.create'); })->name('products.create');
        Route::get('/orders', function () { return view('seller.orders'); })->name('orders');
        Route::get('/withdrawals', function () { return view('seller.withdrawls'); })->name('withdrawals');
    });

});


// ==========================================
// 3. ADMIN SIDE (HALAMAN ADMIN)
// ==========================================

// Hanya bisa diakses oleh user dengan role 'admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
});


// ==========================================
// 4. AUTHENTICATION & USER PROFILE
// ==========================================

// Dashboard User Biasa (Setelah Login)
Route::get('/dashboard', function () { 
    // Jika role sudah seller/admin, akan di-redirect oleh middleware ke dashboard mereka.
    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load file auth bawaan (Login/Register logic)
require __DIR__.'/auth.php';