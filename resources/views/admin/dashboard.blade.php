<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaksi tanpa refresh -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800" x-data="adminDashboard()">

    <div class="flex">
        
        <!-- SIDEBAR -->
        <aside class="w-72 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed z-20 shadow-sm">
            <div class="h-24 flex items-center px-8 border-b border-gray-100">
                <span class="text-3xl mr-3">🛡️</span>
                <div>
                    <span class="font-extrabold text-gray-800 text-lg block leading-none">Admin Panel</span>
                    <span class="text-xs text-orange-500 font-bold tracking-widest uppercase">Super User</span>
                </div>
            </div>
            
            <nav class="p-6 space-y-2">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <!-- MENU DASHBOARD (AKTIF) -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 bg-orange-50 text-orange-700 font-bold rounded-xl border border-orange-100 shadow-sm transition">
                    <span>📊</span> Dashboard
                </a>
                
                <a href="{{ route('admin.users') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition group">
                    <span class="grayscale group-hover:grayscale-0 transition">👥</span> Kelola User
                </a>
                
                <a href="{{ route('admin.stores') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition group">
                    <span class="grayscale group-hover:grayscale-0 transition">🏪</span> Kelola Toko
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mt-8 mb-2">Lainnya</p>
                <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-400 hover:text-orange-600 font-bold rounded-xl transition hover:bg-orange-50">
                    <span>⬅️</span> Kembali
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-72 p-6 md:p-10">
            
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-500 mt-1">Ringkasan aktivitas platform hari ini.</p>
                </div>
                <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-full shadow-sm border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center font-bold text-red-600 border-2 border-white shadow-sm">A</div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 leading-none">Admin Pusat</p>
                        <p class="text-xs text-green-500 font-bold flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Online</p>
                    </div>
                </div>
            </div>

            <!-- STATISTIK (ANGKA DUMMY DINAMIS) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- User Card -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition">👥</div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">+12 Hari Ini</span>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total User</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1" x-text="stats.users.toLocaleString('id-ID')"></p>
                </div>
                
                <!-- Revenue Card -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition">💰</div>
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">+5%</span>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1" x-text="'Rp ' + stats.revenue.toLocaleString('id-ID')"></p>
                </div>

                <!-- Pending Card (Terhubung ke Tabel) -->
                <div class="bg-gradient-to-br from-orange-500 to-red-500 p-6 rounded-3xl shadow-lg text-white transform hover:-translate-y-1 transition cursor-pointer" @click="document.getElementById('verification-table').scrollIntoView({behavior: 'smooth'})">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl backdrop-blur-sm animate-pulse">🔔</div>
                    </div>
                    <p class="text-orange-100 text-xs font-bold uppercase tracking-wider">Verifikasi Toko</p>
                    <p class="text-3xl font-extrabold mt-1"><span x-text="pendingStores.length"></span> Permintaan</p>
                </div>
            </div>

            <!-- TABEL VERIFIKASI (DATA DARI JS) -->
            <div id="verification-table" class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl flex items-center gap-2">
                            Permintaan Buka Toko
                            <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full" x-show="pendingStores.length > 0" x-text="pendingStores.length + ' Pending'"></span>
                        </h3>
                        <p class="text-sm text-gray-400">Verifikasi data seller sebelum menyetujui.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-orange-50/50 text-gray-400 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Info Toko</th>
                                <th class="px-6 py-5">Pemilik</th>
                                <th class="px-6 py-5">Tanggal Daftar</th>
                                <th class="px-6 py-5 text-center">Dokumen</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            <!-- LOOPING DATA -->
                            <template x-for="store in pendingStores" :key="store.id">
                                <tr class="hover:bg-orange-50/30 transition group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-lg">🏪</div>
                                            <div>
                                                <span class="block font-bold text-gray-800 text-base" x-text="store.name"></span>
                                                <span class="text-xs text-gray-400" x-text="'ID: #' + store.id_code"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-200" x-text="store.owner.charAt(0)"></div>
                                            <div>
                                                <span class="font-bold text-gray-600 block" x-text="store.owner"></span>
                                                <span class="text-[10px] text-gray-400" x-text="store.email"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-500 font-mono text-xs" x-text="store.date"></td>
                                    <td class="px-6 py-5 text-center">
                                        <!-- TOMBOL CEK DATA -->
                                        <button @click="openDetail(store)" class="inline-flex items-center gap-1 text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full text-xs cursor-pointer hover:bg-blue-100 transition border border-blue-100">
                                            <span>📄</span> Cek Data
                                        </button>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <!-- TOMBOL TERIMA -->
                                            <button @click="approveStore(store.id)" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition transform hover:-translate-y-0.5 flex items-center gap-1">
                                                <span>✔</span> Terima
                                            </button>
                                            <!-- TOMBOL TOLAK -->
                                            <button @click="rejectStore(store.id)" class="bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 px-4 py-2 rounded-xl text-xs font-bold transition">
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <!-- STATE KOSONG (Jika semua sudah di-approve) -->
                            <tr x-show="pendingStores.length === 0" x-transition>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <span class="text-4xl mb-2">🎉</span>
                                        <p class="font-bold text-gray-500">Semua toko sudah diverifikasi!</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- MODAL DETAIL TOKO (POP-UP) -->
        <div x-show="selectedStore" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="selectedStore = null" class="bg-white rounded-[2rem] w-full max-w-lg p-8 shadow-2xl relative border-4 border-orange-100">
                <button @click="selectedStore = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 font-bold bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">✕</button>

                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center text-3xl shadow-sm mb-3">🏪</div>
                    <h3 class="text-2xl font-extrabold text-gray-900" x-text="selectedStore?.name"></h3>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold mt-2 inline-block">Menunggu Verifikasi</span>
                </div>

                <div class="space-y-3 bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-6">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Nama Pemilik</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.owner"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Email</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.email"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Nomor HP</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.phone"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Kota Asal</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.city"></span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block mb-1">Deskripsi Toko:</span>
                        <p class="text-sm font-medium text-gray-700 italic bg-white p-2 rounded border border-gray-200" x-text="selectedStore?.desc"></p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button @click="rejectStore(selectedStore.id); selectedStore = null" class="flex-1 bg-white border-2 border-red-100 text-red-500 font-bold py-3 rounded-xl hover:bg-red-50 transition">
                        Tolak
                    </button>
                    <button @click="approveStore(selectedStore.id); selectedStore = null" class="flex-1 bg-green-500 text-white font-bold py-3 rounded-xl hover:bg-green-600 shadow-lg transition">
                        Setujui Toko
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- LOGIC JAVASCRIPT (ALPINE.JS) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminDashboard', () => ({
                stats: {
                    users: 1240,
                    revenue: 45000000
                },
                selectedStore: null,
                
                // DATA DUMMY (Bisa ditambah/dikurangi buat demo)
                pendingStores: [
                    { id: 1, id_code: 'TR-8821', name: 'Teddy House Malang', owner: 'Budi Santoso', email: 'budi@gmail.com', phone: '0812-3456-7890', city: 'Malang', date: '04 Des 2025', desc: 'Menjual baju boneka rajut handmade kualitas premium.' },
                    { id: 2, id_code: 'TR-9901', name: 'Boneka Lucu Sby', owner: 'Siti Aminah', email: 'siti@yahoo.com', phone: '0857-1122-3344', city: 'Surabaya', date: '03 Des 2025', desc: 'Spesialis aksesoris kacamata dan topi untuk teddy bear.' },
                    { id: 3, id_code: 'TR-7732', name: 'Gudang Boneka Jkt', owner: 'Rudi Tabuti', email: 'rudi@gmail.com', phone: '0813-9988-7766', city: 'Jakarta', date: '05 Des 2025', desc: 'Distributor resmi outfit boneka impor.' },
                ],

                // Buka Modal
                openDetail(store) {
                    this.selectedStore = store;
                },

                // Fungsi Terima Toko
                approveStore(id) {
                    if(confirm('Setujui toko ini? Mereka akan bisa mulai berjualan.')) {
                        // Hapus dari list pending
                        this.pendingStores = this.pendingStores.filter(s => s.id !== id);
                        alert('Toko berhasil disetujui! Notifikasi dikirim ke seller.');
                    }
                },

                // Fungsi Tolak Toko
                rejectStore(id) {
                    if(confirm('Tolak pengajuan toko ini?')) {
                        // Hapus dari list pending
                        this.pendingStores = this.pendingStores.filter(s => s.id !== id);
                        alert('Pengajuan toko ditolak.');
                    }
                }
            }));
        });
    </script>

</body>
</html>