<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store; 
use Illuminate\Support\Facades\Auth; 

class StoreController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran toko (Form Buka Toko).
     */
    public function create()
    {
        if (Auth::user()->role === 'seller' || Store::where('user_id', Auth::id())->exists()) {
            return redirect('/dashboard-seller')->with('error', 'Anda sudah memiliki toko.');
        }
        
        return view('stores.create'); // Misal view ini bernama create.blade.php
    }

    /**
     * Memproses data dari Form Buka Toko dan menyimpannya ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name', // Nama toko harus unik
            'about' => 'nullable|string',
            // Tambahkan validasi untuk logo, phone, city, address, postal_code
        ]);

        // 2. Cek Duplikasi (Meski sudah ada 'unique()' di migrasi, ini penting di level aplikasi)
        if (Store::where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Anda hanya diizinkan memiliki satu toko.');
        }

        // 3. Insert Data ke Tabel 'stores'
        $store = Store::create([
            'user_id' => Auth::id(), // ID pengguna yang sedang login
            'name' => $request->name,
            'about' => $request->about,
            // Jika ada upload logo
            'logo' => $this->handleLogoUpload($request), 
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false, // Default false sesuai migrasi
        ]);

        // 4. Update Role User menjadi 'seller'
        Auth::user()->update(['role' => 'seller']); 

        return redirect('/dashboard-seller')->with('success', 'Toko berhasil didaftarkan! Selamat berjualan.');
    }
}