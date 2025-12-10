<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'seller' ? __('Seller Panel') : __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <!-- LOGIKA DATA DUMMY -->
    @php
        $isNewUser = true; // Ubah ke false untuk tes tampilan user lama
        
        $saldo = $isNewUser ? 0 : 1500000;
        $pesanan_aktif = $isNewUser ? 0 : 1;
    @endphp

    <div class="py-12 bg-orange-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-[2rem] p-8 text-white shadow-xl mb-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-orange-100 text-lg">Siap menambah koleksi teman bulu barumu hari ini?</p>
                    </div>
                    
                    @if(Auth::user()->role !== 'seller')
                        <a href="{{ route('workshop') }}" class="bg-white text-orange-600 px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-orange-50 transition transform hover:-translate-y-1 flex items-center gap-2">
                            <span>🧸</span> Buat Boneka Baru
                        </a>
                    @else
                        <a href="{{ route('seller.dashboard') }}" class="bg-white text-orange-600 px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-orange-50 transition transform hover:-translate-y-1 flex items-center gap-2">
                            <span>🏪</span> Kelola Toko
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. STATISTIK (SALDO & KOLEKSI) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Kartu Saldo -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl">💰</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Wallet</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}</h4>
                        <a href="{{ route('payment') }}" class="text-xs font-bold text-green-600 hover:underline">+ Isi Saldo</a>
                    </div>
                </div>

                <!-- Kartu Koleksi -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl">🧥</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan Toko</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                        <a href="{{ route('seller.withdrawals') }}" class="text-xs font-bold text-green-600 hover:underline flex items-center gap-1">
                            Tarik Dana <span>➜</span>
                        </a>
                    </div>
                </div>

                <!-- Kartu Status Pesanan -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">📦</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pesanan Aktif</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">{{ $pesanan_aktif }} Paket</h4>
                        <a href="{{ route('history') }}" class="text-xs font-bold text-orange-600 hover:underline">Lacak Paket →</a>
                    </div>
                </div>
            </div>

            <!-- 3. AKTIVITAS TERBARU -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kiri: Riwayat Transaksi -->
                <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <h4 class="font-extrabold text-gray-800 text-lg mb-6">Riwayat Belanja Terakhir</h4>
                    
                    <div class="space-y-4">
                        <!-- Item Dummy 1 -->
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

                        <!-- Item Dummy 2 -->
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

                <!-- Kanan: Menu Cepat -->
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
                        
                        <!-- CTA Buka Toko (Jika bukan seller) -->
                        @if(Auth::user()->role !== 'seller')
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <a href="{{ route('store.register') }}" class="block w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold text-sm text-center shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                                ✨ Buka Toko Sendiri
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>