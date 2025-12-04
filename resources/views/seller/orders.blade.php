<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - Seller Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex">

    <aside class="w-64 bg-white h-screen border-r hidden md:block p-6">
        <h2 class="text-xl font-extrabold text-orange-600 mb-8">Seller Panel</h2>
        <nav class="space-y-2">
            <a href="{{ url('/seller/dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">📦 Produk</a>
            <a href="#" class="block px-4 py-2 bg-orange-50 text-orange-700 font-bold rounded-lg">💰 Pesanan Masuk</a>
            <a href="{{ url('/') }}" class="block px-4 py-2 mt-8 text-gray-400 text-sm hover:text-orange-600">Kembali</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm font-bold text-gray-600 border">
                Saldo: <span class="text-green-600">Rp 1.500.000</span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-orange-50 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Pembeli</th>
                        <th class="px-6 py-4">Barang</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr>
                        <td class="px-6 py-4">
                            <span class="font-bold block">Budi Santoso</span>
                            <span class="text-xs text-gray-400">0812345678</span>
                        </td>
                        <td class="px-6 py-4">1x Kaos Merah UAP</td>
                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate">Jl. Veteran No 10, Malang...</td>
                        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Sudah Dibayar</span></td>
                        <td class="px-6 py-4 text-center">
                            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-orange-700 shadow-lg">
                                🚚 Input Resi
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
