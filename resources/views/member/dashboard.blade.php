<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    @php
        $user = Auth::user();
        $isSeller = $user->role === 'seller';
        $isMember = $user->role === 'member';
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- ======================================================= --}}
                    {{-- KONTEN UNTUK SELLER (Penjual) --}}
                    {{-- ======================================================= --}}
                    @if ($isSeller)
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6 rounded-xl shadow-lg flex justify-between items-center text-white">
                            <div>
                                <h2 class="text-3xl font-extrabold mb-1">Halo, {{ $user->name }}! 🤝</h2>
                                <p class="text-lg font-medium opacity-90">
                                    Semangat jualan hari ini! Ada **{{-- 2 Paket --}}** pesanan yang siap Anda proses.
                                </p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('seller.dashboard') }}" class="bg-white text-orange-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-full shadow-md transition duration-200">
                                    🛍️ Kelola Toko
                                </a>
                            </div>
                        </div>

                        {{-- Kartu Data Seller --}}
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-green-400">
                                <h3 class="text-sm font-semibold text-gray-500 mb-2">PENDAPATAN TOKO</h3>
                                <p class="text-4xl font-extrabold text-green-600">
                                    Rp 1.500.000
                                </p>
                                <a href="#" class="text-sm text-green-400 hover:text-green-600 font-semibold mt-1 inline-block">
                                    Tarik Dana &rarr;
                                </a>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-400">
                                <h3 class="text-sm font-semibold text-gray-500 mb-2">PESANAN MASUK AKTIF</h3>
                                <p class="text-4xl font-extrabold text-blue-600">
                                    2 Paket
                                </p>
                                <a href="{{ route('seller.orders') }}" class="text-sm text-blue-400 hover:text-blue-600 font-semibold mt-1 inline-block">
                                    Lihat Pesanan &rarr;
                                </a>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-gray-400 flex items-center justify-center">
                                <p class="text-gray-500 italic">Statistik Pengunjung (Opsional)</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Transaksi Terakhir</h3>
                            <div class="flex items-center justify-center h-40 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <div class="text-center text-gray-500">
                                    <p>Belum ada riwayat transaksi.</p>
                                    <a href="#" class="text-orange-600 font-semibold hover:text-orange-700 mt-2 inline-block">
                                        Yuk, segera tambah produk pertamamu!
                                    </a>
                                    <div class="mt-4">
                                        <a href="{{ route('seller.products.create') }}" class="bg-orange-600 text-white hover:bg-orange-700 font-bold py-2 px-4 rounded-lg">
                                            Tambah Produk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    {{-- ======================================================= --}}
                    {{-- KONTEN UNTUK MEMBER (Pembeli) - Sesuai Permintaan Anda --}}
                    {{-- ======================================================= --}}
                    @else
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6 rounded-xl shadow-lg flex justify-between items-center text-white">
                            <div>
                                <h2 class="text-3xl font-extrabold mb-1">Halo, {{ $user->name }}! 👏</h2>
                                <p class="text-lg font-medium opacity-90">
                                    Saatnya lengkapi koleksi boneka kesayanganmu! Ada banyak produk baru yang cakep, lho.
                                </p>
                            </div>
                            <div class="flex space-x-3">
                                {{-- Tombol Cek Keranjang (Ditambahkan Sesuai Permintaan) --}}
                                @if (Route::has('cart.index'))
                                    <a href="{{ route('cart.index') }}" class="bg-white text-orange-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-full shadow-md transition duration-200 flex items-center">
                                        🛒 Cek Keranjang Saya
                                    </a>
                                @endif

                                {{-- Tombol Beli Produk (Menggantikan 'Buat Boneka Baru') --}}
                                <a href="/collection" class="bg-yellow-300 text-gray-800 hover:bg-yellow-400 font-bold py-3 px-6 rounded-full shadow-md transition duration-200">
                                    🎁 Beli Produk Favorit
                                </a>
                            </div>
                        </div>
                        
                        {{-- Kartu Data Member --}}
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-400">
                                <h3 class="text-sm font-semibold text-gray-500 mb-2">PESANAN AKTIF</h3>
                                <p class="text-4xl font-extrabold text-blue-600">
                                    0 Paket
                                </p>
                                <a href="{{ route('orders.history') }}" class="text-sm text-blue-400 hover:text-blue-600 font-semibold mt-1 inline-block">
                                    Lacak Paket &rarr;
                                </a>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-gray-400 flex items-center justify-center">
                                <p class="text-gray-500 italic">Area Poin/Kupon (Opsional)</p>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-gray-400 flex items-center justify-center">
                                <p class="text-gray-500 italic">Area Status Toko (Opsional)</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Belanja Terakhir</h3>
                            <div class="flex items-center justify-center h-40 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <div class="text-center text-gray-500">
                                    <p>Belum ada riwayat transaksi.</p>
                                    <a href="/collection" class="text-orange-600 font-semibold hover:text-orange-700 mt-2 inline-block">
                                        Yuk, lihat Koleksi Kami!
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- ======================================================= --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>