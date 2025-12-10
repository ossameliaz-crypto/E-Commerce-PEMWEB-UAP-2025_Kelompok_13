<x-app-layout>
    <x-slot name="header">
<<<<<<< HEAD
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
=======
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
>>>>>>> fd825a2533336941b322560aac78028f655f2aef
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<<<<<<< HEAD
            
            <!-- 1. WELCOME BANNER -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-[2rem] p-8 text-white shadow-xl mb-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-orange-100 text-lg">
                            @if(Auth::user()->role === 'seller')
                                Semangat jualan hari ini! Cek pesanan masuk yuk.
                            @elseif($isNewUser)
                                Selamat datang! Yuk mulai buat boneka pertamamu.
                            @else
                                Siap menambah koleksi teman bulu barumu hari ini?
                            @endif
                        </p>
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

            <!-- 2. STATISTIK -->
            <div class="grid grid-cols-1 {{ Auth::user()->role === 'seller' ? 'md:grid-cols-2' : 'md:grid-cols-1' }} gap-6 mb-10">
                
                <!-- KARTU SALDO (KHUSUS SELLER) -->
                @if(Auth::user()->role === 'seller')
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 text-6xl group-hover:scale-110 transition">💰</div>
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl text-green-600">💸</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan Toko</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                        <a href="{{ route('seller.withdrawals') }}" class="text-xs font-bold text-green-600 hover:underline flex items-center gap-1">
                            Tarik Dana <span>➜</span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- KARTU STATUS PESANAN (SEMUA USER) -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">📦</div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pesanan Aktif</p>
                        <h4 class="text-2xl font-extrabold text-gray-800">{{ $pesanan_aktif }} Paket</h4>
                        <a href="{{ route('history') }}" class="text-xs font-bold text-orange-600 hover:underline">Lacak Paket →</a>
                    </div>
                </div>
            </div>

            <!-- 3. AKTIVITAS TERBARU (Full Width) -->
            <div class="w-full">
                
                <!-- Riwayat Transaksi -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 min-h-[300px]">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-extrabold text-gray-800 text-lg">Riwayat Belanja Terakhir</h4>
                        @if(!$isNewUser)
                            <a href="{{ route('history') }}" class="text-sm font-bold text-orange-600 hover:underline">Lihat Semua</a>
                        @endif
                    </div>
                    
                    @if($isNewUser)
                        <div class="flex flex-col items-center justify-center h-48 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-4xl mb-4 grayscale opacity-50">🛒</div>
                            <p class="text-gray-800 font-bold">Belum ada riwayat belanja.</p>
                            <p class="text-gray-400 text-sm mb-4">Yuk cari boneka pertamamu!</p>
                            <a href="{{ route('workshop') }}" class="px-6 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-bold hover:bg-orange-200 transition">
                                Mulai Belanja
                            </a>
                        </div>
                    @else
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
                    @endif
                </div>

            </div>

=======
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
>>>>>>> fd825a2533336941b322560aac78028f655f2aef
        </div>
    </div>
</x-app-layout>
