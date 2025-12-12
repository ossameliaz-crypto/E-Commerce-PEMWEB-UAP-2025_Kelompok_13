<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController; 
use App\Http\Controllers\CartController; 
use App\Http\Controllers\TransactionController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes (MASTER - FINAL)
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK (Bisa Diakses Siapa Saja) ---
Route::get('/', function () { 
    // Hitungan Keranjang untuk halaman Welcome
    $cartCount = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;
    return view('welcome', compact('cartCount'));
})->name('home');

// Route Workshop menggunakan Controller untuk meneruskan Cart Count
Route::get('/workshop', [CartController::class, 'showWorkshop'])->name('workshop');

// --- HALAMAN INFORMASI (LINK FOOTER) ---
Route::view('/tentang-kami', 'pages.about')->name('about');

// FIX: Kebijakan dipisah agar tidak bentrok
Route::view('/kebijakan-seller', 'pages.seller_policy')->name('seller_policy');
Route::view('/kebijakan-privasi', 'pages.privacy')->name('policy');

Route::view('/lokasi-store', 'pages.location')->name('location');
Route::view('/hubungi-kami', 'pages.contact')->name('contact');

// Halaman Bantuan Tambahan
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/pengembalian-dana', 'pages.refund_policy')->name('refund_policy');
Route::get('/lacak-pesanan', function () { return view('pages.track_order'); })->name('track_order');


// --- 2. CUSTOMER AUTH (Harus Login) ---
Route::middleware(['auth'])->group(function () {
    
    // WARDROBE / KERANJANG
    Route::get('/wardrobe', [CartController::class, 'index'])->name('wardrobe');
    // Route POST untuk menambahkan item dari Workshop (Dukungan AJAX)
    Route::post('/cart/add-custom', [CartController::class, 'addToCart'])->name('cart.add-custom');
    
    // Route DELETE untuk menghapus item tunggal
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); 
    
    // Route DELETE untuk menghapus item massal (Bulk Delete)
    Route::delete('/cart/bulk-delete', [CartController::class, 'bulkDestroy'])->name('cart.bulk_destroy'); 

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

    // 🌟 PERBAIKAN KRUSIAL (PENAMBAHAN ROUTE YANG HILANG) 🌟
    // Rute untuk Update Password
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    // Rute untuk Update Gambar/Logo (Penyebab error 'Route not defined')
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.update-image');
// Tambahkan {id} karena kita butuh ID Order, dan ganti 'payment' jadi 'showPayment'
Route::get('/payment/{id}', [TransactionController::class, 'showPayment'])->name('payment.show');
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
    
    // [BARU] Kelola User
    Route::get('/users', function () { return view('admin.users'); })->name('users');
    
    // [BARU] Kelola Toko (List Semua Toko)
    Route::get('/stores', function () { return view('admin.stores'); })->name('stores');
});

require __DIR__.'/auth.php';