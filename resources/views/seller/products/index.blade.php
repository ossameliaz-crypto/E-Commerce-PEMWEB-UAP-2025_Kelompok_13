<x-app-layout>
    {{-- Mengisi variabel $header pada app.blade.php --}}
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk Saya') }}
        </h2>
    </x-slot>

    {{-- KONTEN UTAMA (menggantikan @section('content')) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Bagian Daftar Produk (Sama seperti kode Anda sebelumnya) --}}
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Produk Anda</h2>
                    <a href="{{ route('seller.products.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150">
                        + Tambah Produk
                    </a>
                </div>

                {{-- Pesan Sukses --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                {{-- Tabel untuk Menampilkan Produk --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            {{-- Cek apakah ada produk yang dikirim dari controller --}}
                            @forelse ($products as $product)
                            <tr>
                                {{-- 1. Tampilkan Gambar Produk --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $image = $product->productImages->first();
                                    @endphp
                                    @if ($image)
                                        <img src="{{ Storage::url($image->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded-full">
                                    @else
                                        
                                    @endif
                                </td>

                                {{-- 2. Nama Produk --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">Slug: {{ $product->slug }}</div>
                                </td>
                                
                                {{-- 3. Kategori --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</div>
                                </td>

                                {{-- 4. Harga --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp. {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                {{-- 5. Stok --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $product->stock }} pcs
                                    </span>
                                </td>

                                {{-- 6. Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Semua data gambar akan ikut terhapus.')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada produk yang terdaftar. Silakan klik "Tambah Produk" di atas.
                                </td>
                            </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>