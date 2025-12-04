<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-orange-50/50 min-h-screen font-sans text-gray-800">

    <div class="flex">
        
        <!-- SIDEBAR -->
        <aside class="w-72 bg-white border-r border-orange-100 min-h-screen hidden md:block fixed z-20">
            <div class="h-24 flex items-center px-8 border-b border-gray-50">
                <span class="text-3xl mr-3">🛡️</span>
                <div>
                    <span class="font-extrabold text-gray-800 text-lg block leading-none">Admin Panel</span>
                    <span class="text-xs text-orange-500 font-bold tracking-widest uppercase">Super User</span>
                </div>
            </div>
            
            <nav class="p-6 space-y-2">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/20 transition transform hover:-translate-y-0.5">
                    <span>📊</span> Dashboard
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-orange-50 hover:text-orange-600 font-bold rounded-2xl transition group">
                    <span class="grayscale group-hover:grayscale-0 transition">👥</span> Kelola User
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-orange-50 hover:text-orange-600 font-bold rounded-2xl transition group">
                    <span class="grayscale group-hover:grayscale-0 transition">🏪</span> Kelola Toko
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mt-8 mb-2">Lainnya</p>
                <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-400 hover:text-orange-600 font-bold rounded-2xl transition">
                    <span>⬅️</span> Kembali ke Web
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-72 p-6 md:p-10">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Overview</h1>
                    <p class="text-gray-500 mt-1">Pantau aktivitas toko dan transaksi hari ini.</p>
                </div>
                <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-full shadow-sm border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-400 to-red-500 p-0.5">
                        <div class="w-full h-full bg-white rounded-full flex items-center justify-center font-bold text-orange-600">A</div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 leading-none">Admin Pusat</p>
                        <p class="text-xs text-green-500 font-bold">● Online</p>
                    </div>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Card 1 -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-orange-50 hover:shadow-lg transition group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 text-blue-500 rounded-2xl text-2xl group-hover:scale-110 transition">👥</div>
                        <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total User</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">1,240</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-orange-50 hover:shadow-lg transition group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-green-50 text-green-500 rounded-2xl text-2xl group-hover:scale-110 transition">💰</div>
                        <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full">+5%</span>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">Rp 45jt</p>
                </div>
                <!-- Card 3 (Action Needed) -->
                <div class="bg-gradient-to-br from-orange-500 to-red-500 p-8 rounded-[2rem] shadow-lg text-white hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-white/20 rounded-2xl text-2xl backdrop-blur-sm">🔔</div>
                    </div>
                    <p class="text-orange-100 text-xs font-bold uppercase tracking-wider">Verifikasi Toko</p>
                    <p class="text-3xl font-extrabold mt-1">3 Pending</p>
                </div>
            </div>

            <!-- TABEL VERIFIKASI -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl">Permintaan Buka Toko</h3>
                        <p class="text-sm text-gray-400">Verifikasi data seller sebelum menyetujui.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-orange-50/50 text-gray-400 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Info Toko</th>
                                <th class="px-6 py-5">Pemilik</th>
                                <th class="px-6 py-5">Tanggal</th>
                                <th class="px-6 py-5 text-center">Status Dokumen</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <!-- Item 1 -->
                            <tr class="hover:bg-orange-50/30 transition group">
                                <td class="px-8 py-5">
                                    <span class="block font-bold text-gray-800 text-lg">Teddy House Malang</span>
                                    <span class="text-xs text-gray-400">ID: #TR-8821</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">B</div>
                                        <span class="font-bold text-gray-600">Budi Santoso</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-gray-500 font-mono">04 Des 2025</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center gap-1 text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full text-xs cursor-pointer hover:bg-blue-100 transition">
                                        📄 Lihat KTP
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold mr-2 shadow-sm hover:shadow-md transition">✔ Terima</button>
                                    <button class="bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-500 px-4 py-2 rounded-xl text-xs font-bold transition">✖ Tolak</button>
                                </td>
                            </tr>
                            <!-- Item 2 -->
                            <tr class="hover:bg-orange-50/30 transition group">
                                <td class="px-8 py-5">
                                    <span class="block font-bold text-gray-800 text-lg">Boneka Lucu Sby</span>
                                    <span class="text-xs text-gray-400">ID: #TR-9901</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">S</div>
                                        <span class="font-bold text-gray-600">Siti Aminah</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-gray-500 font-mono">03 Des 2025</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center gap-1 text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full text-xs cursor-pointer hover:bg-blue-100 transition">
                                        📄 Lihat KTP
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold mr-2 shadow-sm hover:shadow-md transition">✔ Terima</button>
                                    <button class="bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-500 px-4 py-2 rounded-xl text-xs font-bold transition">✖ Tolak</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>