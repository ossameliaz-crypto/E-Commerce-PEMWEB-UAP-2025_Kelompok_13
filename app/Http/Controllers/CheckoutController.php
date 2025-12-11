<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // Biaya Kirim DITETAPKAN DI SERVER untuk konsistensi
    private $defaultShippingFee = 25000;

    /**
     * TAHAP 1: Menghitung total akhir (tanpa diskon/voucher) dan menampilkan halaman checkout/pengiriman.
     */
    public function checkout(Request $request)
    {
        $selectedIds = $request->input('selected_ids');

        if (empty($selectedIds)) {
            return redirect()->route('wardrobe')->with('error', 'Pilih item yang ingin dibayar.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
                        ->whereIn('id', $selectedIds)
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Item yang dipilih tidak ditemukan atau bukan milik Anda.');
        }
        
        // 1. HITUNG SUBTOTAL MURNI (Total Harga Item)
        $subtotal = $cartItems->sum('total_price');
        
        // Karena tidak ada voucher/diskon:
        $finalTotalItems = $subtotal;
        $shippingFee = $this->defaultShippingFee;
        $totalDue = $finalTotalItems + $shippingFee;

        // 2. SIMPAN DATA HARGA KE SESSION
        Session::put('checkout_data', [
            'selected_ids' => $selectedIds,
            'subtotal' => (int) $subtotal,
            'final_total_items' => (int) $finalTotalItems, // Ini yang akan menjadi Total Pesanan di Payment
            'shipping_fee' => (int) $shippingFee,
            'total_due' => (int) $totalDue,
        ]);
        
        // 3. Tampilkan halaman konfirmasi pengiriman (checkout.blade.php)
        // Jika Anda ingin langsung ke pembayaran setelah checkout dari keranjang,
        // ganti baris di bawah ini:
        // return redirect()->route('payment'); 
        
        return view('checkout', [
            'cartItems' => $cartItems,
            'totalAmount' => $finalTotalItems, // Total Harga Item (setelah diskon/voucher)
            'shippingFee' => $shippingFee,
            'totalDue' => $totalDue,
        ]);
    }

    /**
     * TAHAP 2: Menampilkan halaman Pembayaran (Kasir).
     */
    public function showPayment()
    {
        // 1. AMBIL DATA HARGA DARI SESSION
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('wardrobe')->with('error', 'Sesi checkout tidak ditemukan. Mulai ulang dari keranjang.');
        }

        // 2. TERUSKAN DATA HARGA YANG SUDAH KONSISTEN
        return view('payment_view', [
            // Variabel-variabel ini HARUS SAMA PERSIS dengan yang ada di x-data HTML Anda
            'totalAmount' => $checkoutData['final_total_items'], // Total Harga Item (Subtotal)
            'shippingFee' => $checkoutData['shipping_fee'],      // Biaya Kirim
            'totalDue' => $checkoutData['total_due'],            // Total Akhir yang Harus Dibayar
        ]);
    }
}