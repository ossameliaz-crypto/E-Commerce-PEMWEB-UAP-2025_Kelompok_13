<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen p-6 md:p-10">

    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Riwayat Belanja 🛍️</h1>
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali ke Beranda</a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-orange-50 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Resi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-mono font-bold text-gray-600">#TRX-88291</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🧸</span>
                                <div>
                                    <p class="font-bold text-gray-800">Custom Teddy Bear</p>
                                    <p class="text-xs text-gray-500">+ Baju Merah</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold">Rp 170.000</td>
                        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu Pembayaran</span></td>
                        <td class="px-6 py-4 text-gray-400">-</td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-mono font-bold text-gray-600">#TRX-11029</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">👕</span>
                                <div>
                                    <p class="font-bold text-gray-800">Kaos Polos</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold">Rp 55.000</td>
                        <td class="px-6 py-4"><span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Sedang Dikirim</span></td>
                        <td class="px-6 py-4 font-mono text-gray-600">JP882199201</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>