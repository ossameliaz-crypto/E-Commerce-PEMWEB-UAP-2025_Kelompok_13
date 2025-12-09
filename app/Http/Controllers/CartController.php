<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product; // Pastikan model Product ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang (Halaman Wardrobe)
     */
    public function index()
    {
        // Ambil data keranjang milik user yang sedang login
        // Diurutkan dari yang terbaru
        $carts = Cart::where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        // Kirim data ke view 'wardrobe'
        return view('wardrobe', compact('carts'));
    }

    /**
     * Menyimpan Item dari Workshop ke Database
     */
    public function addToCart(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'base' => 'required',
            'size' => 'required',
            'action_type' => 'required', // 'buy' atau 'cart'
        ]);

        // 2. Hitung Harga di Backend (Security Best Practice)
        // Kita hitung ulang di sini biar user gak bisa manipulasi harga via Inspect Element
        $totalPrice = 0;

        // Harga Base Body (Boneka)
        $pricesBase = ['S' => 100000, 'M' => 150000, 'L' => 250000];
        $totalPrice += $pricesBase[$request->size] ?? 0;

        // Harga Outfit (Contoh Logic: Cek ID barang, atau hardcode sesuai kesepakatan)
        // Idealnya: $product = Product::find($request->outfit); $totalPrice += $product->price;
        // Simulasi sesuai Frontend:
        if ($request->outfit && $request->outfit != 'none') {
            $totalPrice += match($request->outfit) {
                'kaos' => 50000,
                'hoodie' => 75000,
                'dress' => 65000,
                default => 0
            };
        }

        // Harga Aksesoris
        if ($request->accessory && $request->accessory != 'none') {
            $totalPrice += match($request->accessory) {
                'kacamata' => 25000,
                'topi' => 35000,
                'pita' => 15000,
                default => 0
            };
        }

        // Harga Fitur Suara
        if ($request->voice) {
            if ($request->voice == 'record') $totalPrice += 75000;
            elseif ($request->voice != 'none') $totalPrice += 30000;
        }

        // Harga Wangi
        if ($request->scent && $request->scent != 'none') {
            $totalPrice += ($request->scent == 'bubblegum' || $request->scent == 'lavender') ? 20000 : 15000;
        }

        // Harga Gift Box
        if ($request->gift_box) {
            if ($request->gift_box == 'premium') $totalPrice += 25000;
            elseif ($request->gift_box == 'birthday') $totalPrice += 30000;
        }


        // 3. Handle Upload Rekaman Suara (Blob)
        $voicePath = null;
        if ($request->hasFile('audio_blob')) {
            $file = $request->file('audio_blob');
            // Nama file unik: voice_USERID_TIMESTAMP.webm
            $filename = 'voice_' . Auth::id() . '_' . time() . '.webm';
            
            // Simpan ke folder: storage/app/public/voices
            // Pastikan sudah jalanin: php artisan storage:link
            $path = $file->storeAs('voices', $filename, 'public');
            $voicePath = $path;
        }


        // 4. Simpan Data ke Tabel Carts
        $cart = Cart::create([
            'user_id'       => Auth::id(), // Pastikan user sudah login
            'base_model'    => $request->base,
            'size'          => $request->size,
            'outfit_id'     => $request->outfit == 'none' ? null : $request->outfit,
            'accessory_id'  => $request->accessory == 'none' ? null : $request->accessory,
            
            // Fitur Custom
            'voice_type'    => $request->voice,
            'voice_file'    => $voicePath,
            'scent_type'    => $request->scent,
            'gift_box'      => $request->gift_box,
            'card_message'  => $request->card_message,
            'is_dressed'    => $request->dress_bear === 'true', // Konversi string 'true' ke boolean
            
            'total_price'   => $totalPrice,
        ]);

        // 5. Redirect Sesuai Tombol yang Ditekan
        if ($request->action_type == 'buy') {
            // Jika Beli Sekarang, arahkan ke Checkout
            // Opsional: Kirim ID cart yang baru dibuat biar di checkout langsung kepilih
            return redirect()->route('checkout')->with('direct_checkout_id', $cart->id);
        } else {
            // Jika Masuk Keranjang, arahkan ke Wardrobe dengan pesan sukses
            return redirect()->route('wardrobe')->with('success', 'Boneka berhasil masuk keranjang!');
        }
    }
    
    /**
     * Menghapus Item dari Keranjang
     */
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if ($cart) {
            $cart->delete();
            // Hapus file rekaman jika ada, biar hemat storage
            if ($cart->voice_file && Storage::disk('public')->exists($cart->voice_file)) {
                Storage::disk('public')->delete($cart->voice_file);
            }
            return back()->with('success', 'Item dihapus.');
        }
        
        return back()->with('error', 'Item tidak ditemukan.');
    }
}