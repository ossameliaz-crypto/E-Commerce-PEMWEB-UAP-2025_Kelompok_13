<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\Product; 
use App\Models\Store; 
use App\Models\ProductCategory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule; 

class ProductController extends Controller
{
    // Pastikan app/Http/Controllers/Controller.php sudah mewarisi BaseController
    // agar middleware() bisa dipanggil (Lihat Perbaikan Wajib 2)
    // app/Http/Controllers/ProductController.php

    public function __construct()
    {
        $this->middleware('auth'); 
        // GANTI 'role:seller' dengan nama class lengkap
        $this->middleware(\App\Http\Middleware\CheckRole::class . ':seller'); 
    }
    
    // --- Index (Menampilkan Daftar Produk) ---
    public function index()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
             return redirect()->route('store.register')->with('error', 'Anda harus mendaftarkan toko terlebih dahulu.');
        }

        $products = Product::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        
        // Asumsi 'seller.dashboard' menampilkan daftar produk
        return view('seller.dashboard', compact('products'));
    }

    // --- Create (Menampilkan Form Tambah Produk) ---
    public function create()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('store.register')->with('error', 'Anda harus mendaftarkan toko terlebih dahulu.');
        }
        
        $categories = ProductCategory::all(); 
        
        // PERBAIKAN: View sudah menggunakan notasi folder yang benar.
        return view('seller.products.create', compact('categories')); 
    }

    // --- Store (Menyimpan Produk Baru) ---
    public function store(Request $request)
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect()->route('store.register')->with('error', 'Toko tidak ditemukan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id', 
            'description' => 'required|string', 
            'condition' => 'required|in:new,second', 
            'price' => 'required|numeric|min:1000', 
            'weight' => 'required|integer|min:1', 
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        $imagePath = null;
        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products/images', 'public');
            }

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
                'image' => $imagePath, 
            ]);

            DB::commit();
            return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan!'); 

        } catch (\Exception $e) {
            DB::rollBack();
            if ($imagePath) { Storage::disk('public')->delete($imagePath); }
            \Log::error('Gagal menyimpan produk: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }

    // --- Edit (Menampilkan Form Edit Produk) ---
    public function edit(Product $product)
    {
        // Pengecekan otorisasi
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit produk ini.');
        }

        $categories = ProductCategory::all();
        
        // PERBAIKAN: View sudah menggunakan notasi folder yang benar.
        return view('seller.products.edit', compact('product', 'categories'));
    }

    // --- Update (Memperbarui Produk) ---
    public function update(Request $request, Product $product)
    {
        // Pengecekan otorisasi
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        DB::beginTransaction();
        $oldImagePath = $product->image;
        $newImagePath = null; 

        try {
            $product->fill($request->only([
                'name', 'product_category_id', 'description', 
                'condition', 'price', 'weight', 'stock'
            ]));
            
            if ($request->hasFile('image')) {
                if ($oldImagePath) { Storage::disk('public')->delete($oldImagePath); }
                
                $newImagePath = $request->file('image')->store('products/images', 'public');
                $product->image = $newImagePath;
            }

            $product->save();
            DB::commit();
            
            return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($newImagePath && $request->hasFile('image')) {
                Storage::disk('public')->delete($newImagePath);
            }
            \Log::error('Gagal memperbarui produk: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }

    // --- Destroy (Menghapus Produk) ---
    public function destroy(Product $product)
    {
        // Pengecekan otorisasi
        if (!Auth::user()->store || Auth::user()->store->id !== $product->store_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus produk ini.');
        }

        DB::beginTransaction();

        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            
            DB::commit();
            return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus produk: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Gagal menghapus produk. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }
}