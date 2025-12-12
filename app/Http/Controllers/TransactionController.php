<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js; // Tambahkan ini untuk helper JS

class TransactionController extends Controller
{
    public function checkout()
    {
        $selectedIds = request()->query('selected_ids', []);
        
        $carts = Cart::where('user_id', Auth::id())
                     ->whereIn('id', $selectedIds)
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Pilih item untuk Checkout!');
        }

        $cartTotal = $carts->sum('total_price');

        return view('checkout', compact('carts', 'cartTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'shipping_courier' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:carts,id',
        ]);
        
        $itemIdsToProcess = $request->input('item_ids');
        $carts = Cart::where('user_id', Auth::id())->whereIn('id', $itemIdsToProcess)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('wardrobe')->with('error', 'Tidak ada item yang akan diproses.');
        }

        $subtotal = $carts->sum('total_price');
        $shippingCost = $request->input('shipping_cost');
        $grandTotal = $subtotal + $shippingCost;

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'user_id' => Auth::id(), // Pastikan migration user_id sudah dijalankan
                'invoice_code' => 'TRX-' . time() . rand(100,999),
                'status' => 'pending',
                'total_price' => $grandTotal, 
                'recipient_name' => $request->input('name'),
                'recipient_phone' => $request->input('phone'),
                'address' => $request->input('address') . ', ' . $request->input('city') . ', ' . $request->input('postal_code'),
                'courier' => $request->input('shipping_courier'),
                'shipping_cost' => $shippingCost,
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

            Cart::where('user_id', Auth::id())->whereIn('id', $itemIdsToProcess)->delete();
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction failed: ' . $e->getMessage());
            return redirect()->route('wardrobe')->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }

        return redirect()->route('payment');
    }

    public function payment()
    {
        return view('payment');
    }

    /**
     * PERBAIKAN UTAMA DI SINI
     * Kita format datanya di Controller supaya View bersih & tidak error
     */
    public function history()
    {
        $rawTransactions = Transaction::where('user_id', Auth::id())
                                      ->with('details')
                                      ->latest()
                                      ->get();

        // Format data menjadi Array/JSON-ready structure
        $transactions = $rawTransactions->map(function($t) {
            $firstDetail = $t->details->first();
            $itemsDesc = '';
            
            if ($firstDetail) {
                $itemsDesc = 'Size: ' . $firstDetail->size . 
                             ($firstDetail->outfit_id ? ' + Baju' : '') . 
                             ($firstDetail->accessory_id ? ' + Aksesoris' : '');
            }

            return [
                'id' => $t->invoice_code, 
                // Menggunakan format tanggal Indonesia
                'date' => \Carbon\Carbon::parse($t->created_at)->isoFormat('D MMMM Y'), 
                'total' => $t->total_price, 
                'status' => $t->status, // pending, shipped, completed
                'resi' => $t->resi_number ?? 'Belum ada',
                'items' => [
                    [
                        'name' => ucfirst($firstDetail->base_model ?? 'Produk') . ' Bear', 
                        'desc' => $itemsDesc
                    ]
                ],
            ];
        });

        // Kirim $transactions yang sudah rapi ke view
        return view('history', compact('transactions'));
    }
}