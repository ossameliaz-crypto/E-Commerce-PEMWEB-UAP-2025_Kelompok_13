<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <div class="flex">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed">
            <div class="h-20 flex items-center px-8 border-b border-gray-100">
                <span class="text-2xl mr-2">🧸</span>
                <span class="font-extrabold text-orange-600 text-lg">Seller Panel</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition">
                    <span>📦</span> Produk Saya
                </a>
                <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>💰</span> Pesanan
                </a>
                <a href="{{ route('seller.withdrawals') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span>⚙️</span> Dompet Saya
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
            
            <!-- INFO BAR -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">ℹ️</div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">Sistem Fulfillment</h3>
                        <p class="mt-1 text-sm text-blue-700">Pastikan stok fisik sudah dikirim ke Gudang Pusat sebelum mengaktifkan produk di sini.</p>
                    </div>
                </div>
            </div>

            <!-- HEADER & TOMBOL TAMBAH -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">Daftar Produk</h1>
                    <p class="text-gray-500 mt-1">Kelola stok dan harga barang daganganmu.</p>
                </div>
                
                <!-- [PERBAIKAN] Menggunakan tag <a> bukan <button> agar pindah halaman -->
                <a href="{{ route('seller.products.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                    <span>+</span> Tambah Produk
                </a>
            </div>

            <!-- TABEL PRODUK -->
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
                            
                            <!-- DATA DUMMY 1 -->
                            <tr class="hover:bg-orange-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">👕</div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">Kaos Merah UAP</span>
                                            <span class="text-xs text-gray-400">Kategori: Outfit</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-mono text-gray-600">Rp 50.000</td>
                                <td class="px-6 py-5 text-gray-600 font-bold">120 pcs</td>
                                <td class="px-6 py-5"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Ready</span></td>
                                <td class="px-6 py-5 text-right">
                                    <!-- [PERBAIKAN] Tombol Edit & Hapus Diberi Aksi Javascript -->
                                    <button onclick="alert('Fitur Edit akan dijalankan oleh Backend!')" class="text-gray-400 hover:text-blue-600 font-bold mr-3 transition">Edit</button>
                                    <button onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-gray-400 hover:text-red-600 font-bold transition">Hapus</button>
                                </td>
                            </tr>

                            <!-- DATA DUMMY 2 -->
                            <tr class="hover:bg-orange-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">🧥</div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">Hoodie Biru</span>
                                            <span class="text-xs text-gray-400">Kategori: Outfit</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-mono text-gray-600">Rp 75.000</td>
                                <td class="px-6 py-5 text-gray-600 font-bold">50 pcs</td>
                                <td class="px-6 py-5"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Ready</span></td>
                                <td class="px-6 py-5 text-right">
                                    <button onclick="alert('Fitur Edit akan dijalankan oleh Backend!')" class="text-gray-400 hover:text-blue-600 font-bold mr-3 transition">Edit</button>
                                    <button onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-gray-400 hover:text-red-600 font-bold transition">Hapus</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Dummy -->
                <div class="p-4 border-t border-gray-100 text-center text-xs text-gray-400">
                    Menampilkan 2 dari 2 produk
                </div>
            </div>

        </main>
    </div>

</body>
</html>