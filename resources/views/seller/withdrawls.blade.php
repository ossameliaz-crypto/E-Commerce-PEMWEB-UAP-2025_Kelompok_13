<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dompet Toko - Seller Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; } [x-cloak] { display: none; }</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">

    <div class="flex" x-data="{ openModal: false }">
        
        <!-- SIDEBAR (Konsisten dengan Dashboard) -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed z-10">
            <div class="h-20 flex items-center px-8 border-b border-gray-100">
                <span class="text-2xl mr-2">🧸</span>
                <span class="font-extrabold text-orange-600 text-lg">Seller Panel</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition">
                    <span>🏠</span> Dashboard 
                </a>
                <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>📄</span> Pesanan
                </a>
                <!-- Menu Aktif -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition shadow-sm border border-orange-100">
                    <span>💰</span> Dompet Saya
                </a>
                
                <div class="pt-8 mt-8 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-orange-600 font-bold text-sm transition">
                        <span>⬅️</span> Kembali ke Toko
                    </a>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-64 p-8">
            
            <!-- Header -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">Keuangan Toko</h1>
                    <p class="text-gray-500 mt-1">Kelola pendapatan dan pencairan dana.</p>
                </div>
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rekening Terdaftar</p>
                    <p class="font-bold text-gray-800">BCA • 1234567890</p>
                </div>
            </div>

            <!-- SALDO CARD (Gradient Style) -->
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-orange-500/20 mb-10 relative overflow-hidden">
                <!-- Hiasan -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-orange-100 font-bold uppercase tracking-widest text-xs mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Saldo Dapat Ditarik
                        </p>
                        <h2 class="text-5xl font-extrabold tracking-tight">Rp 1.500.000</h2>
                        <p class="text-sm text-orange-100 mt-3 opacity-90">*Dana tertahan: Rp 250.000 (Menunggu konfirmasi pembeli)</p>
                    </div>

                    <div>
                        <button @click="openModal = true" class="bg-white text-orange-600 px-8 py-4 rounded-2xl font-bold shadow-lg hover:bg-orange-50 transition transform hover:-translate-y-1 flex items-center gap-2">
                            <span>💸</span> Tarik Dana
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT TRANSAKSI -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-xl">Riwayat Mutasi</h3>
                    <button class="text-sm text-orange-600 font-bold hover:underline">Download Laporan</button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-orange-50/50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-6 py-5">Keterangan</th>
                                <th class="px-6 py-5">Tipe</th>
                                <th class="px-6 py-5 text-right">Nominal</th>
                                <th class="px-6 py-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            <!-- Transaksi Masuk (Penjualan) -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-5 text-gray-500">06 Des 2025</td>
                                <td class="px-6 py-5">
                                    <span class="font-bold text-gray-700">Penjualan #ORD-8821</span>
                                    <span class="block text-xs text-gray-400">Kaos Merah UAP (1x)</span>
                                </td>
                                <td class="px-6 py-5"><span class="text-green-600 font-bold text-xs bg-green-50 px-2 py-1 rounded">Pemasukan</span></td>
                                <td class="px-6 py-5 text-right font-bold text-green-600">+ Rp 50.000</td>
                                <td class="px-6 py-5 text-center"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span></td>
                            </tr>

                            <!-- Transaksi Keluar (Penarikan) -->
                            <tr class="hover:bg-gray-50 transition bg-orange-50/20">
                                <td class="px-8 py-5 text-gray-500">05 Des 2025</td>
                                <td class="px-6 py-5">
                                    <span class="font-bold text-gray-700">Penarikan Dana</span>
                                    <span class="block text-xs text-gray-400">Ke BCA ****890</span>
                                </td>
                                <td class="px-6 py-5"><span class="text-red-600 font-bold text-xs bg-red-50 px-2 py-1 rounded">Penarikan</span></td>
                                <td class="px-6 py-5 text-right font-bold text-gray-800">- Rp 500.000</td>
                                <td class="px-6 py-5 text-center"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Diproses</span></td>
                            </tr>

                            <!-- Transaksi Masuk (Penjualan) -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-5 text-gray-500">01 Des 2025</td>
                                <td class="px-6 py-5">
                                    <span class="font-bold text-gray-700">Penjualan #ORD-7710</span>
                                    <span class="block text-xs text-gray-400">Hoodie Biru (2x)</span>
                                </td>
                                <td class="px-6 py-5"><span class="text-green-600 font-bold text-xs bg-green-50 px-2 py-1 rounded">Pemasukan</span></td>
                                <td class="px-6 py-5 text-right font-bold text-green-600">+ Rp 150.000</td>
                                <td class="px-6 py-5 text-center"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- MODAL FORM PENARIKAN -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="openModal = false" class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl relative border-4 border-orange-100 transform transition-all scale-100">
                
                <button @click="openModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center">✕</button>
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">💸</div>
                    <h3 class="text-2xl font-extrabold text-gray-800">Tarik Saldo</h3>
                    <p class="text-gray-500 text-sm">Dana akan ditransfer ke rekening utama.</p>
                </div>

                <form action="#" method="POST"> 
                    @csrf
                    <div class="space-y-5">
                        <!-- Input Nominal -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Penarikan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">Rp</span>
                                <input type="number" class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-0 outline-none font-bold text-xl text-gray-800 placeholder-gray-300" placeholder="0">
                            </div>
                            <div class="flex justify-between mt-2 text-xs">
                                <span class="text-gray-400">Min. Rp 50.000</span>
                                <span class="text-orange-600 font-bold cursor-pointer hover:underline">Tarik Semua</span>
                            </div>
                        </div>

                        <!-- Info Rekening -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-gray-200 font-bold text-blue-800 text-xs">BCA</div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">BCA - Ossa Putri</p>
                                <p class="text-xs text-gray-500">1234****890</p>
                            </div>
                            <a href="#" class="ml-auto text-xs text-orange-600 font-bold hover:underline">Ubah</a>
                        </div>

                        <!-- Tombol -->
                        <button type="button" @click="openModal = false; alert('Permintaan penarikan berhasil dikirim ke Admin!')" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold py-4 rounded-xl hover:shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                            Konfirmasi Penarikan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>
</html>

<nav class="p-4 space-y-2 mt-4">
    <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition shadow-sm border border-orange-100">
        <span>📦</span> Produk Saya
    </a>
    <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
        <span>📄</span> Pesanan
    </a>
    <a href="{{ route('seller.withdrawals') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
        <span>💰</span> Dompet Saya
    </a>
    <!-- ... tombol kembali ... -->
</nav>