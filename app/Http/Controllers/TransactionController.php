<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini jika menggunakan DB Transactions

class TransactionController extends Controller
{
    /**
     * Menampilkan Halaman Checkout
     */
    public function checkout()
    {
        $selectedIds = request()->query('selected_ids', []);
        
        // Ambil item yang ID-nya ada di selected_ids dari Keranjang
        $carts = Cart::where('user_id', Auth::id())
                     ->whereIn('id', $selectedIds)
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Pilih item untuk Checkout!');
        }

        $cartTotal = $carts->sum('total_price');

        // Meneruskan carts (item yang akan diproses) dan total harga ke view checkout
        return view('checkout', compact('carts', 'cartTotal'));
    }

    /**
     * Proses Simpan Transaksi (Saat klik Bayar)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'shipping_courier' => 'required|string', // Kurir yang dipilih
            'shipping_cost' => 'required|numeric', // Biaya kirim dari AlpineJS
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:carts,id',
        ]);
        
        $itemIdsToProcess = $request->input('item_ids');
        $carts = Cart::where('user_id', Auth::id())->whereIn('id', $itemIdsToProcess)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Tidak ada item yang akan diproses.');
        }

        // 2. Hitung Total & Ongkir dari Request
        $subtotal = $carts->sum('total_price');
        $shippingCost = $request->input('shipping_cost');
        $grandTotal = $subtotal + $shippingCost;

        // 3. Simpan Transaksi Utama & Detail
        try {
            DB::beginTransaction();

            // ASUMSI: Kolom di tabel transactions adalah user_id
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'invoice_code' => 'TRX-' . time() . rand(100,999),
                'status' => 'pending',
                'total_price' => $grandTotal, 
                'recipient_name' => $request->input('name'),
                'recipient_phone' => $request->input('phone'),
                'address' => $request->input('address') . ', ' . $request->input('city') . ', ' . $request->input('postal_code'),
                'courier' => $request->input('shipping_courier'),
                'shipping_cost' => $shippingCost, // Tambahkan biaya kirim ke tabel Transaction
                'resi_number' => null,
            ]);

            $defaultProduct = Product::first();
            $safeProductId = $defaultProduct ? $defaultProduct->id : 1; 

            foreach ($carts as $cart) {
                
                $voiceInfo = $cart->voice_type;
                if ($cart->voice_type === 'record' && $cart->voice_file) {
                    $voiceInfo = 'Rekaman: ' . $cart->voice_file;
                }

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $safeProductId, 
                    'base_model' => $cart->base_model,
                    'size' => $cart->size,
                    'outfit_id' => $cart->outfit_id,
                    'accessory_id' => $cart->accessory_id,
                    'voice_message' => $voiceInfo, 
                    'scent' => $cart->scent_type,
                    'gift_box' => $cart->gift_box,
                    'is_dressed' => $cart->is_dressed,
                    'price' => $cart->total_price 
                ]);
            }

            // 4. Hapus Keranjang (Hanya item yang sudah diproses)
            Cart::where('user_id', Auth::id())->whereIn('id', $itemIdsToProcess)->delete();
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction failed: ' . $e->getMessage());
            // Mengalihkan ke Wardrobe jika ada error
            return redirect()->route('wardrobe')->with('error', 'Gagal memproses transaksi. Mohon coba lagi. (Error: ' . $e->getMessage() . ')');
        }

        // 5. Redirect ke Payment
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