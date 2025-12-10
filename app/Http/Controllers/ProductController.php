<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\Product; 
// 💡 TAMBAHKAN MODEL ProductImage
use App\Models\ProductImage; 
use App\Models\Store; 
use App\Models\ProductCategory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Konstruktor dan metode Index, Show, Create tidak perlu diubah.
    public function __construct()
    {
        $this->middleware('auth'); 
        $this->middleware('role:seller'); 
    }
    
    // ... (metode index, show, create sudah benar, kode dihilangkan untuk fokus pada perbaikan CRUD) ...

    // --- Index (Menampilkan Daftar Produk) ---
    public function index()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('store.register')->with('error', 'Anda harus mendaftarkan toko terlebih dahulu.');
        }
        $products = Product::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        return view('seller.products.index', compact('products'));
    }

    // --- Show (Menampilkan Detail Produk) ---
    public function show(Product $product)
    {
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat detail produk ini.');
        }
        return view('seller.products.show', compact('product'));
    }

    // --- Create (Menampilkan Form Tambah Produk) ---
    public function create()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('store.register')->with('error', 'Anda harus mendaftarkan toko terlebih dahulu.');
        }
        $categories = ProductCategory::all(); 
        return view('seller.products.create', compact('categories')); 
    }


    // --- Store (Menyimpan Produk Baru) ---
    public function store(Request $request)
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('store.register')->with('error', 'Toko tidak ditemukan.');
        }

        // 💡 VALIDASI DIUBAH: Kolom 'image' Dihapus dari Product, tetapi file 'image' tetap di-validate
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id', 
            'description' => 'required|string', 
            'condition' => 'required|in:new,second', 
            'price' => 'required|numeric|min:1000', 
            'weight' => 'required|integer|min:1', 
            'stock' => 'required|integer|min:0',
            // Gambar harus diisi untuk produk baru
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        $imagePath = null;
        DB::beginTransaction();

        try {
            // 1. BUAT DATA PRODUK (Tabel products)
            $product = Product::create([
                'store_id' => $store->id, 
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . time(), 
                'product_category_id' => $request->product_category_id,
                'description' => $request->description,
                'condition' => $request->condition, 
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
                // Kolom 'image' DITIADAKAN di sini karena akan disimpan di ProductImage
            ]);

            // 2. SIMPAN GAMBAR KE STORAGE DAN KE TABEL product_images
            if ($request->hasFile('image')) {
                // Simpan file
                $imagePath = $request->file('image')->store('products/images', 'public');
                
                // Simpan path ke tabel product_images
                $product->productImages()->create([
                    'image' => $imagePath,
                    'is_thumbnail' => 1, // Gambar pertama dijadikan thumbnail
                ]);
            }

            DB::commit();
            
            return redirect()->route('seller.products.index')->with('success', 'Produk dan gambar berhasil ditambahkan!'); 

        } catch (\Exception $e) {
            DB::rollBack();
            // Jika transaksi gagal, hapus file yang sudah terupload
            if ($imagePath) { Storage::disk('public')->delete($imagePath); } 
            
            Log::error('Gagal menyimpan produk (Transaksi): ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }

    // --- Edit (Menampilkan Form Edit Produk) ---
    public function edit(Product $product)
    {
        // Otorisasi
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit produk ini.');
        }

        $categories = ProductCategory::all();
        
        return view('seller.products.edit', compact('product', 'categories'));
    }

    // --- Update (Memperbarui Produk) ---
    public function update(Request $request, Product $product)
    {
        // Otorisasi
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui produk ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string', 
            'condition' => 'required|in:new,second', 
            'price' => 'required|numeric|min:1000',
            'weight' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            // Gambar boleh null (jika user tidak upload baru)
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        DB::beginTransaction();
        $newImagePath = null; 

        try {
            // 1. UPDATE DATA PRODUK (Tabel products)
            $product->fill($request->only([
                'name', 'product_category_id', 'description', 
                'condition', 'price', 'weight', 'stock'
            ]))->save();
            
            // 2. UPDATE/TAMBAH GAMBAR (Tabel product_images)
            if ($request->hasFile('image')) {
                // Cari thumbnail lama
                $oldThumbnail = $product->productImages()->where('is_thumbnail', 1)->first();
                
                // Simpan gambar baru
                $newImagePath = $request->file('image')->store('products/images', 'public');
                
                if ($oldThumbnail) {
                    // Hapus file lama dari storage
                    Storage::disk('public')->delete($oldThumbnail->image);
                    
                    // Update ProductImage yang lama
                    $oldThumbnail->update(['image' => $newImagePath]);
                } else {
                    // Jika belum ada thumbnail, buat entri baru
                    $product->productImages()->create([
                        'image' => $newImagePath,
                        'is_thumbnail' => 1,
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Jika ada gambar baru di-upload tapi transaksi gagal, hapus gambar barunya
            if ($newImagePath && $request->hasFile('image')) {
                Storage::disk('public')->delete($newImagePath);
            }
            Log::error('Gagal memperbarui produk: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }

    // --- Destroy (Menghapus Produk) ---
    public function destroy(Product $product)
    {
        // Otorisasi
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus produk ini.');
        }

        DB::beginTransaction();

        try {
            // Hapus semua file gambar yang terkait dengan produk ini
            foreach ($product->productImages as $image) {
                if ($image->image) {
                    Storage::disk('public')->delete($image->image);
                }
                // ProductImage akan otomatis terhapus karena cascadeOnDelete pada migration (asumsi)
            }

            $product->delete();
            
            DB::commit();
            return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus produk: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Gagal menghapus produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }
}