<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Dashboard</title>
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
                {{-- [PERBAIKAN] Dashboard seharusnya aktif di sini --}}
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 font-bold rounded-xl transition">
                    <span>🏠</span> Dashboard 
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
                    <h1 class="text-3xl font-extrabold text-gray-800">Dashboard Seller</h1>
                    <p class="text-gray-500 mt-1">Ringkasan aktivitas dan performa tokomu.</p>
                </div>
                {{-- TOMBOL TAMBAH PRODUK DIHAPUS dari dashboard --}}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 text-center">
                    <p class="text-sm text-gray-500 font-bold">Total Penjualan</p>
                    <p class="text-3xl font-extrabold text-orange-600 mt-2">Rp 1.250.000</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 text-center">
                    <p class="text-sm text-gray-500 font-bold">Produk Aktif</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-2">15</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 text-center">
                    <p class="text-sm text-gray-500 font-bold">Pesanan Baru</p>
                    <p class="text-3xl font-extrabold text-blue-600 mt-2">3</p>
                </div>

            </div>

        </main>
    </div>

</body>
</html>