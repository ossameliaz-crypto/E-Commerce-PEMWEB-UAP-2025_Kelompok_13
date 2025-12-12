<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard berdasarkan peran (role) pengguna yang login.
     */
    public function index(): View
    {
        $user = Auth::user();

        // 1. Logika untuk Admin
        if ($user->role === 'admin') {
            $adminData = [ 'user_count' => 100 ]; 
            return view('admin.dashboard', $adminData);
        }

        // 2. Logika untuk Seller (Halaman ini yang salah dilihat 'shellss' sebelumnya)
        if ($user->role === 'seller') {
            // Data sesuai dengan tampilan Seller di screenshot
            $pendapatan_toko = 1500000; 
            $pesanan_aktif = 2; 
            $riwayat_transaksi_ada = false; 
            
            $sellerData = compact('pendapatan_toko', 'pesanan_aktif', 'riwayat_transaksi_ada');

            return view('seller.dashboard', $sellerData);
        }

        // 3. Logika Default untuk Member ('shellss' seharusnya masuk ke sini)
        // Data yang dioper harus sesuai dengan view member.dashboard
        $item_di_keranjang = 3; 
        $pesanan_selesai = 5; 
        $workshop_aktif = 1;
        
        // Mengarahkan ke view Member
        return view('member.dashboard', compact('item_di_keranjang', 'pesanan_selesai', 'workshop_aktif'));
    }
}