<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View; // Tambahkan ini
use Illuminate\Http\JsonResponse; // Tambahkan ini untuk respons AJAX
use Illuminate\Http\RedirectResponse; // Tambahkan ini untuk respons redirect

class CartController extends Controller
{
    // --- Data Konstan ini HARUS SAMA PERSIS dengan array 'items' di builder.blade.php ---
    private function getHardcodedPrices(): array
    {
        // Data ini dikembalikan sebagai array. (Tidak ada perubahan pada data ini)
        return [
            'bodies' => [
                'coklat' => 150000, 'krem' => 150000, 'polar' => 155000, 'panda' => 160000, 
                'pink' => 150000, 'deer' => 175000, 'kitty' => 200000, 'bluey' => 180000, 
                'bunny' => 165000, 'cinamon' => 185000
            ],
            'outfits' => [
                'none' => 0, 'tuxedo' => 95000, 'kaos' => 50000, 'hoodie' => 75000, 
                'dress' => 65000, 'piyama' => 55000, 'denim' => 85000, 'polisi' => 80000, 
                'dokter' => 75000, 'astronaut' => 120000
            ],
            'accessories' => [
                'none' => 0, 'kacamata' => 25000, 'topi' => 35000, 'pita' => 15000, 
                'mahkota' => 45000, 'earmuff' => 40000, 'tas' => 30000, 'syal' => 20000, 
                'bunga' => 15000, 'masker' => 10000
            ],
            'voices' => [
                'none' => 0, 'love' => 30000, 'bday' => 30000, 'laugh' => 25000, 'lullaby' => 35000, 
                'congrats' => 30000, 'gws' => 30000, 'morning' => 25000, 'animal' => 25000, 'sorry' => 30000,
                'record' => 75000 // Harga Rekam Sendiri
            ],
            'scents' => [
                'none' => 0, 'vanilla' => 15000, 'strawberry' => 15000, 'chocolate' => 15000, 
                'bubblegum' => 20000, 'lavender' => 20000, 'coffee' => 15000, 'rose' => 20000, 
                'lemon' => 15000, 'baby' => 20000
            ],
            'gifts' => [
                'none' => 0, 'premium' => 25000, 'birthday' => 30000, 'love' => 35000, 
                'christmas' => 35000, 'lebaran' => 30000, 'graduation' => 30000, 'mystery' => 50000, 
                'transparent' => 60000, 'basket' => 45000
            ]
        ];
    }
    
    // Helper function untuk mendapatkan harga item berdasarkan ID
    private function getItemPrice(?string $id, string $category): int
    {
        $prices = $this->getHardcodedPrices();
        if ($id === null || $id === 'none') return 0;
        return $prices[$category][$id] ?? 0;
    }


    /**
     * Menampilkan halaman Workshop dan Meneruskan Hitungan Keranjang.
     */
    public function showWorkshop(): View
    {
        // Dipanggil oleh route('workshop')
        $cartCount = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;
        return view('builder', compact('cartCount'));
    }
    
    /**
     * Menampilkan isi keranjang (Halaman Lemari Saya / Cart Index)
     */
    public function index(): View
    {
        // Dipanggil oleh route('cart.index')
        
        // Ambil data keranjang milik user yang sedang login
        $cartItems = Cart::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        // Hitung total harga (Total estimasi belum termasuk ongkir)
        $totalHarga = $cartItems->sum('total_price');

        // FIX: Mengganti view 'wardrobe' menjadi 'member.cart'
        return view('member.cart', [
            'cartItems' => $cartItems, 
            'totalHarga' => $totalHarga,
        ]);
    }

    /**
     * Menyimpan Item dari Workshop ke Database
     * @return RedirectResponse|JsonResponse
     */
    public function addToCart(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'base' => 'required|string',
            'size' => 'required|string',
            'action_type' => 'required|string',
            // Tambahkan validasi untuk file audio jika voice adalah 'record'
            'audio_blob' => $request->voice == 'record' ? 'nullable|file|mimes:webm,mp3,ogg,wav|max:5000' : 'nullable', 
        ]);

        // 2. Hitung Harga Total (SINKRONISASI HARGA)
        
        // a. Base Price + Size Adjustment
        $totalPrice = $this->getItemPrice($request->base, 'bodies');
        
        if ($request->size === 'S') {
            $totalPrice -= 20000;
        } elseif ($request->size === 'XL') {
            $totalPrice += 50000;
        }
        
        // b. Item Kustomisasi lainnya
        $totalPrice += $this->getItemPrice($request->outfit, 'outfits');
        $totalPrice += $this->getItemPrice($request->accessory, 'accessories');
        
        // c. Harga Fitur Suara (Termasuk 'record')
        $totalPrice += $this->getItemPrice($request->voice, 'voices');

        // d. Harga Wangi
        $totalPrice += $this->getItemPrice($request->scent, 'scents');

        // e. Harga Gift Box
        $totalPrice += $this->getItemPrice($request->gift_box, 'gifts');


        // 3. Handle Upload Rekaman Suara (Blob)
        $voicePath = null;
        if ($request->voice == 'record' && $request->hasFile('audio_blob')) {
            $file = $request->file('audio_blob');
            $filename = 'voice_' . Auth::id() . '_' . time() . '.' . $file->extension();
            
            try {
                // Simpan file ke storage/app/public/voices
                $path = $file->storeAs('voices', $filename, 'public');
                $voicePath = $path;
            } catch (\Exception $e) {
                // Log error jika diperlukan
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Gagal menyimpan file rekaman suara.'], 500);
                }
                return back()->with('error', 'Gagal menyimpan file rekaman suara. Coba lagi.')->withInput();
            }
        }


        // 4. Simpan Data ke Tabel Carts
        $cart = Cart::create([
            'user_id'       => Auth::id(),
            'base_model'    => $request->base,
            'size'          => $request->size,
            'outfit_id'     => $request->outfit == 'none' ? null : $request->outfit,
            'accessory_id'  => $request->accessory == 'none' ? null : $request->accessory,
            
            'voice_type'    => $request->voice,
            'voice_file'    => $voicePath,
            'scent_type'    => $request->scent,
            'gift_box'      => $request->gift_box,
            'card_message'  => $request->card_message,
            'is_dressed'    => $request->dress_bear === 'true',
            
            'total_price'   => $totalPrice, 
        ]);

        // 5. Redirect Sesuai Tombol yang Ditekan (AJAX / Non-AJAX)
        $cartCount = Cart::where('user_id', Auth::id())->count();

        if ($request->action_type == 'buy') {
            // Langsung ke Checkout (Beli Sekarang)
            return redirect()->route('checkout')->with('direct_cart_id', $cart->id);
        } 
        
        if ($request->ajax() && $request->action_type == 'cart') {
             // Respons sukses untuk tombol 'Tambahkan ke Keranjang' (AJAX)
             return response()->json([
                 'success' => true,
                 'cart_count' => $cartCount,
                 'message' => 'Item berhasil ditambahkan ke keranjang!'
             ]);
        }

        // Default redirect (Misalnya jika tidak menggunakan AJAX atau 'buy')
        return redirect()->route('cart.index')->with('success', 'Boneka berhasil ditambahkan ke keranjang!');
    }
    
    /**
     * Menghapus Item dari Keranjang (Tunggal)
     */
    public function destroy(int $id): RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if ($cart) {
            // Hapus file rekaman suara jika ada
            if ($cart->voice_file && Storage::disk('public')->exists($cart->voice_file)) {
                Storage::disk('public')->delete($cart->voice_file);
            }
            $cart->delete();
            return back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }
        
        return back()->with('error', 'Item keranjang tidak ditemukan.');
    }
    
    /**
     * Menghapus Item dari Keranjang (Massal/Bulk)
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        // Pastikan input berupa array ID
        $ids = $request->input('selected_ids'); 
        
        if (!empty($ids) && is_array($ids)) {
            $cartsToDelete = Cart::where('user_id', Auth::id())->whereIn('id', $ids)->get();
            $deletedCount = 0;
            
            foreach ($cartsToDelete as $cart) {
                // Hapus file rekaman suara jika ada
                if ($cart->voice_file && Storage::disk('public')->exists($cart->voice_file)) {
                    Storage::disk('public')->delete($cart->voice_file);
                }
                $cart->delete();
                $deletedCount++;
            }
            
            return back()->with('success', $deletedCount . ' item berhasil dihapus dari keranjang.');
        }
        
        return back()->with('error', 'Tidak ada item yang dipilih untuk dihapus.');
    }
}