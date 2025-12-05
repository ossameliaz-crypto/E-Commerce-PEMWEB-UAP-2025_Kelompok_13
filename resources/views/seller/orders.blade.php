<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Seller Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">

    <!-- x-data ditambah untuk Modal Restock -->
    <div class="flex" x-data="{ openRestockModal: false, selectedProductRestock: '' }">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed z-10">
            <div class="h-20 flex items-center px-8 border-b border-gray-100">
                <span class="text-2xl mr-2">🧸</span>
                <span class="font-extrabold text-orange-600 text-lg">Seller Panel</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>📦</span> Produk Saya
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition shadow-sm border border-orange-100">
                    <span>📄</span> Laporan Penjualan
                </a>
                <a href="{{ route('seller.withdrawals') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
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
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">Laporan Penjualan</h1>
                    <p class="text-gray-500 mt-1">Pantau barangmu yang laku dan sedang diproses oleh Gudang Pusat.</p>
                </div>
                
                <!-- TOMBOL KIRIM STOK BARU -->
                <button @click="openRestockModal = true; selectedProductRestock = ''" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-800 transition transform hover:-translate-y-1 flex items-center gap-2">
                    <span>📦</span> Kirim Stok ke Gudang
                </button>
            </div>

            <!-- STOCK ALERT (TAMPILAN BARU: PEMBERITAHUAN STOK HABIS) -->
            <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8 rounded-r-xl shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-red-500 text-xl">⚠️</div>
                    <div class="ml-4 w-full">
                        <h3 class="text-lg font-bold text-red-800">Stok Kritis! Segera Restock</h3>
                        <p class="text-sm text-red-700 mb-3">
                            Produk berikut telah habis di Gudang Pusat. Produk otomatis <b>disembunyikan/dinonaktifkan</b> dari katalog pembeli sampai stok tersedia kembali.
                        </p>
                        
                        <div class="flex gap-4">
                            <!-- Item Habis 1 -->
                            <div class="bg-white p-3 rounded-lg border border-red-200 flex items-center justify-between shadow-sm w-full md:w-1/2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center">👗</div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Dress Pink</p>
                                        <p class="text-xs text-red-600 font-bold">Stok Gudang: 0</p>
                                    </div>
                                </div>
                                <button @click="openRestockModal = true; selectedProductRestock = 'Dress Pink'" class="text-xs bg-red-600 text-white px-3 py-2 rounded-lg font-bold hover:bg-red-700 transition">
                                    Kirim Stok
                                </button>
                            </div>
                            
                            <!-- Item Habis 2 -->
                            <div class="bg-white p-3 rounded-lg border border-yellow-200 flex items-center justify-between shadow-sm w-full md:w-1/2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center">🎩</div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Topi Sulap</p>
                                        <p class="text-xs text-yellow-600 font-bold">Stok Gudang: 2 (Menipis)</p>
                                    </div>
                                </div>
                                <button @click="openRestockModal = true; selectedProductRestock = 'Topi Sulap'" class="text-xs bg-yellow-500 text-white px-3 py-2 rounded-lg font-bold hover:bg-yellow-600 transition">
                                    Tambah Stok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL PENJUALAN -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-orange-50/50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-6 py-5">Item Terjual</th>
                                <th class="px-6 py-5">Pendapatan</th>
                                <th class="px-6 py-5">Status Pengiriman (Pusat)</th>
                                <th class="px-6 py-5 text-center">Status Dana</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            <!-- ITEM 1: Baru Masuk -->
                            <tr class="hover:bg-orange-50/30 transition">
                                <td class="px-8 py-5 text-gray-500">07 Des 2025</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-lg">👕</div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">Kaos Merah UAP</span>
                                            <span class="text-xs text-gray-400">Order #8821</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-bold text-green-600">+ Rp 50.000</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                                        Sedang Dikemas Admin
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-xs font-bold text-gray-400">Tertahan</span>
                                </td>
                            </tr>

                            <!-- ITEM 2: Sudah Dikirim Admin -->
                            <tr class="hover:bg-orange-50/30 transition bg-gray-50/50">
                                <td class="px-8 py-5 text-gray-500">05 Des 2025</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-lg">🧥</div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">Hoodie Biru</span>
                                            <span class="text-xs text-gray-400">Order #7730</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-bold text-green-600">+ Rp 75.000</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                        🚀 Dikirim (JP123456)
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Masuk Dompet</span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- MODAL RESTOCK (PENGIRIMAN DARI SELLER KE GUDANG) -->
        <div x-show="openRestockModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" 
             x-cloak x-transition>
            
            <div @click.away="openRestockModal = false" class="bg-white rounded-[2rem] w-full max-w-lg p-8 shadow-2xl relative border-4 border-gray-100">
                
                <button @click="openRestockModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 font-bold bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">✕</button>
                
                <h3 class="text-2xl font-extrabold text-gray-800 mb-2">Kirim Stok ke Gudang</h3>
                <p class="text-gray-500 text-sm mb-6">Silakan kirim barang fisik Anda ke alamat berikut:</p>

                <!-- Alamat Gudang -->
                <div class="bg-orange-50 border-2 border-orange-200 border-dashed rounded-xl p-4 mb-6 relative">
                    <p class="font-bold text-orange-800 text-sm uppercase mb-1">📍 Alamat Gudang Pusat</p>
                    <p class="text-gray-700 font-bold">Build-A-Teddy Fulfillment Center</p>
                    <p class="text-gray-600 text-sm">Jl. Veteran No. 10 (Fakultas Ilmu Komputer), Malang, Jawa Timur, 65145.</p>
                    <p class="text-gray-600 text-sm mt-1">UP: Admin Gudang (0812-3456-7890)</p>
                </div>

                <form action="#" method="POST">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Produk yang Dikirim</label>
                            <!-- x-model biar otomatis terpilih kalau klik dari alert merah -->
                            <select x-model="selectedProductRestock" class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 outline-none bg-white">
                                <option value="" disabled selected>Pilih Produk...</option>
                                <option value="Dress Pink">Dress Pink (Habis)</option>
                                <option value="Topi Sulap">Topi Sulap (Menipis)</option>
                                <option value="Kaos Merah UAP">Kaos Merah UAP</option>
                                <option value="Hoodie Biru">Hoodie Biru</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jumlah (Qty)</label>
                                <input type="number" class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Contoh: 20">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kurir Anda</label>
                                <input type="text" class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="JNE / Sendiri">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Resi Pengiriman</label>
                            <input type="text" class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 outline-none font-mono uppercase" placeholder="Masukkan Resi Pengiriman Anda">
                            <p class="text-xs text-gray-400 mt-1">*Admin akan memverifikasi stok setelah barang sampai.</p>
                        </div>

                        <button type="button" @click="openRestockModal = false; alert('Konfirmasi terkirim! Admin akan mengecek barang Anda saat sampai.')" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg mt-2">
                            Konfirmasi Pengiriman
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>