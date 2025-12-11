<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use App\Http\Controllers\CartController; 
use App\Http\Controllers\TransactionController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes (MASTER - FINAL)
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK ---
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/workshop', function () { return view('builder'); })->name('workshop');

// --- 2. CUSTOMER AUTH ---
Route::middleware(['auth'])->group(function () {
    
    // WARDROBE / KERANJANG
    Route::get('/wardrobe', [CartController::class, 'index'])->name('wardrobe');
    Route::post('/cart/add-custom', [CartController::class, 'addToCart'])->name('cart.add-custom');
    
    // [BARU] Fitur Hapus Keranjang
    Route::delete('/cart/bulk-delete', [CartController::class, 'bulkDestroy'])->name('cart.bulk_destroy'); // Hapus Banyak
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Hapus Satu

    // CHECKOUT & TRANSAKSI
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [TransactionController::class, 'store'])->name('checkout.process');
    Route::get('/payment', [TransactionController::class, 'payment'])->name('payment');
    Route::get('/history', [TransactionController::class, 'history'])->name('history');

    // DASHBOARD & PROFIL
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- 3. SELLER SIDE ---
Route::middleware(['auth'])->group(function () {
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create'); 
    

    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', function () { return view('seller.dashboard'); })->name('dashboard');
        Route::get('/products', function () { return view('seller.dashboard'); })->name('products.index');
        Route::get('/products/create', function () { return view('seller.products.create'); })->name('products.create');
        Route::get('/orders', function () { return view('seller.orders'); })->name('orders');
        Route::get('/withdrawals', function () { return view('seller.withdrawls'); })->name('withdrawals');
    });
});


// --- 4. ADMIN SIDE ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
});

require __DIR__.'/auth.php';