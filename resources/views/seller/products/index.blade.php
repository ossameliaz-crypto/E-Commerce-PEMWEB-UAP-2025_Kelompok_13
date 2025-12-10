{{-- File: resources/views/seller/products/index.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Daftar Produk</title>
    {{-- Memuat Tailwind CSS dari CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <div class="flex">
        
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed">
            <div class="h-20 flex items-center px-8 border-b border-gray-100">
                <span class="text-2xl mr-2">🧸</span>
                <span class="font-extrabold text-orange-600 text-lg">Seller Panel</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                {{-- Link Dashboard (Bukan aktif di halaman ini) --}}
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>🏠</span> Dashboard
                </a>
                
                {{-- Link Produk Saya (ACTIVE di halaman ini) --}}
                <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition">
                    <span>📦</span> Produk 
                </a>
                <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>💰</span> Pesanan
                </a>
                <a href="{{ route('seller.withdrawals') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>⚙️</span> Dompet 
                </a>
                
                <div class="pt-8 mt-8 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-orange-600 font-bold text-sm transition">
                        <span>⬅️</span> Kembali ke Toko
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 md:ml-64 p-8">
            
            <a href="{{ route('seller.dashboard') }}" class="text-gray-500 hover:text-orange-600 font-bold text-sm mb-6 inline-flex items-center gap-1 transition">
                <span>⬅️</span> Kembali ke Dashboard
            </a>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-8 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">✅</div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">ℹ️</div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">Sistem Fulfillment</h3>
                        <p class="mt-1 text-sm text-blue-700">Pastikan stok fisik sudah dikirim ke Gudang Pusat sebelum mengaktifkan produk di sini.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">Daftar Produk</h1>
                    <p class="text-gray-500 mt-1">Kelola stok dan harga barang daganganmu.</p>
                </div>
                
                {{-- Tombol Tambah Produk --}}
                <a href="{{ route('seller.products.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                    <span>+</span> Tambah Produk
                </a>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-orange-50/50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Nama Produk</th>
                                <th class="px-6 py-5">Harga</th>
                                <th class="px-6 py-5">Stok Gudang</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            @forelse ($products as $product)
                            <tr class="hover:bg-orange-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        {{-- TAMPIL GAMBAR --}}
                                        @php
                                            $image = $product->productImages->first();
                                        @endphp
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-xl overflow-hidden group-hover:scale-110 transition">
                                            @if ($image)
                                                <img src="{{ Storage::url($image->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                📦
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">{{ $product->name }}</span>
                                            <span class="text-xs text-gray-400">Kategori: {{ $product->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-mono text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-gray-600 font-bold">{{ $product->stock }} pcs</td>
                                <td class="px-6 py-5">
                                    @if ($product->stock > 0)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Ready</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Stok Habis</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('seller.products.edit', $product) }}" class="text-gray-400 hover:text-blue-600 font-bold mr-3 transition">Edit</a>
                                    
                                    {{-- FORM UNTUK DELETE --}}
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-gray-400 hover:text-red-600 font-bold transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-orange-50/30 transition">
                                <td colspan="5" class="px-8 py-10 text-center text-gray-500 font-bold">
                                    Belum ada produk yang terdaftar. Silakan klik "Tambah Produk".
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-gray-100 text-center text-xs text-gray-400">
                    @if(isset($products))
                        Menampilkan {{ $products->count() }} dari {{ $products->count() }} produk
                    @else
                        Menampilkan 0 produk
                    @endif
                </div>
            </div>

        </main>
    </div>

</body>
</html>