<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Menampilkan Halaman Checkout
     */
    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Keranjang kosong!');
        }

        $cartTotal = $carts->sum('total_price');

        return view('checkout', compact('carts', 'cartTotal'));
    }

    /**
     * Proses Simpan Transaksi (Saat klik Bayar)
     */
    public function store(Request $request)
    {
        // 1. Ambil Keranjang
        $carts = Cart::where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe');
        }

        // 2. Hitung Total & Ongkir
        $subtotal = $carts->sum('total_price');
        
        $city = strtolower($request->input('city', ''));
        $isMalang = str_contains($city, 'malang');
        $courier = $request->input('courier');
        
        $shippingCost = 25000; // Default
        if ($isMalang) {
            $shippingCost = match($courier) {
                'jne' => 8000, 'jnt' => 10000, 'gosend' => 15000, default => 20000
            };
        } else {
            $shippingCost = match($courier) {
                'jne' => 22000, 'jnt' => 28000, default => 25000
            };
        }

        // 3. Simpan Transaksi Utama
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'invoice_code' => 'TRX-' . time() . rand(100,999),
            'status' => 'pending',
            'total_price' => $subtotal + $shippingCost,
            'recipient_name' => $request->input('name'),
            'recipient_phone' => $request->input('phone'),
            'address' => $request->input('address') . ', ' . $request->input('city') . ', ' . $request->input('postal_code'),
            'courier' => $courier,
            'resi_number' => null,
        ]);

        // 4. Simpan Detail Item (Pindahkan dari Cart)
        // Kita butuh Product ID default untuk mencegah error foreign key
        $defaultProduct = Product::first();
        $safeProductId = $defaultProduct ? $defaultProduct->id : 1; 

        foreach ($carts as $cart) {
            
            // LOGIKA PINTAR: Tentukan isi kolom voice_message
            // Jika rekam sendiri, simpan path filenya. Jika template, simpan jenisnya.
            $voiceInfo = $cart->voice_type;
            if ($cart->voice_type === 'record' && $cart->voice_file) {
                $voiceInfo = 'Rekaman: ' . $cart->voice_file; // Simpan path agar Admin bisa buka
            }

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $safeProductId, 
                
                // Simpan detail kustomisasi
                'voice_message' => $voiceInfo, // <--- INI YG DIPERBAIKI
                'scent' => $cart->scent_type,
                'gift_box' => $cart->gift_box,
                'is_dressed' => $cart->is_dressed,
                'price' => $cart->total_price
            ]);
        }

        // 5. Hapus Keranjang (Karena sudah dipindah ke transaksi)
        Cart::where('user_id', Auth::id())->delete();

        // 6. Redirect ke Payment
        return redirect()->route('payment');
    }

    public function payment()
    {
        return view('payment');
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                                   ->with('details')
                                   ->latest()
                                   ->get();
        return view('history', compact('transactions'));
    }
}