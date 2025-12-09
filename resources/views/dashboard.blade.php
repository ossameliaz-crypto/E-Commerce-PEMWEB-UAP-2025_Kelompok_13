<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'seller' ? __('Seller Panel') : __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-orange-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-[2rem] p-8 text-white shadow-xl mb-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-orange-100 text-lg">
                            @if(Auth::user()->role === 'seller')
                                Selamat datang di Seller Panel Anda.
                            @else
                                Siap menambah koleksi teman bulu barumu hari ini?
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('workshop') }}" class="bg-white text-orange-600 px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-orange-50 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <span>🧸</span> Buat Boneka Baru
                    </a>
                </div>
            </div>

            @if(Auth::user()->role === 'seller')
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 mb-10">
                    
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h4 class="text-2xl font-extrabold text-gray-800">Daftar Produk Saya</h4>
                        <a href="{{ route('seller.products.create') }}" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-600 transition flex items-center gap-2 transform hover:scale-105">
                            + Tambah Produk
                        </a>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 rounded-lg mb-6">
                        <p class="font-bold">Sistem Fulfillment</p>
                        <p class="text-sm">Pastikan stok fisik sudah dikirim ke Gudang Pusat sebelum mengaktifkan produk di sini.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NAMA PRODUK</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">HARGA</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">STOK GUDANG</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">STATUS</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($products ?? [] as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-3xl mr-3">{!! $product->icon ?? '👕' !!}</div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">Kategori: {{ $product->category->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">{{ number_format($product->stock, 0, ',', '.') }} pcs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ready</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 transition mr-4">
                                            Edit
                                        </a>

                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE') 
                                            <button type="submit" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}? Aksi ini tidak dapat dibatalkan.')" 
                                                    class="text-red-600 hover:text-red-900 transition border-none bg-transparent p-0 cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Belum ada produk yang didaftarkan. Klik "Tambah Produk" di atas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl">💰</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Wallet</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}</h4>
                        <a href="{{ route('payment') }}" class="text-xs font-bold text-green-600 hover:underline">+ Isi Saldo</a>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl">🧥</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Isi Lemari</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">12 Item</h4>
                        <a href="{{ route('wardrobe') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Koleksi →</a>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">📦</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pesanan Aktif</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">1 Paket</h4>
                        <a href="{{ route('history') }}" class="text-xs font-bold text-orange-600 hover:underline">Lacak Paket →</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <h4 class="font-extrabold text-gray-800 text-lg mb-6">Riwayat Belanja Terakhir</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-orange-50 transition cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-xl shadow-sm">🧸</div>
                                <div>
                                    <p class="font-bold text-gray-800">Custom Teddy (Coklat)</p>
                                    <p class="text-xs text-gray-500">22 Des 2025 • #TRX-88291</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Selesai</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-orange-50 transition cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-xl shadow-sm">👕</div>
                                <div>
                                    <p class="font-bold text-gray-800">Kaos Merah UAP</p>
                                    <p class="text-xs text-gray-500">20 Des 2025 • #TRX-11029</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Dikirim</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <h4 class="font-extrabold text-gray-800 text-lg mb-6">Akses Cepat</h4>
                    <div class="space-y-3">
                        <a href="{{ route('workshop') }}" class="block w-full py-3 px-4 bg-gray-50 hover:bg-orange-100 rounded-xl text-gray-700 font-bold text-sm transition flex justify-between items-center group">
                            <span>🎨 Mulai Kustomisasi</span>
                            <span class="text-gray-400 group-hover:text-orange-500">➔</span>
                        </a>
                        <a href="{{ route('wardrobe') }}" class="block w-full py-3 px-4 bg-gray-50 hover:bg-blue-100 rounded-xl text-gray-700 font-bold text-sm transition flex justify-between items-center group">
                            <span>🧥 Ganti Baju Boneka</span>
                            <span class="text-gray-400 group-hover:text-blue-500">➔</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block w-full py-3 px-4 bg-gray-50 hover:bg-gray-100 rounded-xl text-gray-700 font-bold text-sm transition flex justify-between items-center group">
                            <span>⚙️ Pengaturan Akun</span>
                            <span class="text-gray-400 group-hover:text-gray-600">➔</span>
                        </a>
                        
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            @if(Auth::user()->role !== 'seller')
                                <a href="{{ route('store.register') }}" class="block w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold text-sm text-center shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                                    ✨ Buka Toko Sendiri
                                </a>
                            @else
                                <a href="{{ route('seller.dashboard') }}" class="block w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold text-sm text-center shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                                    💼 Akses Seller Panel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>