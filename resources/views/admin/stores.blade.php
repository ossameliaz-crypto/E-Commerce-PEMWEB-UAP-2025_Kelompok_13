<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Toko - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800"
      x-data="storeManager()">

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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition"><span>📊</span> Dashboard</a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition group"><span class="grayscale group-hover:grayscale-0 transition">👥</span> Kelola User</a>
                
                <!-- MENU AKTIF -->
                <a href="{{ route('admin.stores') }}" class="flex items-center gap-4 px-4 py-3.5 bg-orange-50 text-orange-700 font-bold rounded-xl border border-orange-100 shadow-sm transition">
                    <span>🏪</span> Kelola Toko
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mt-8 mb-2">Lainnya</p>
                <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-400 hover:text-orange-600 font-bold rounded-xl transition hover:bg-orange-50"><span>⬅️</span> Kembali ke Web</a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-72 p-6 md:p-10">
            
            <!-- Header & Filter -->
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Daftar Mitra Toko</h1>
                    <p class="text-gray-500 mt-1">Kelola <span x-text="stores.length"></span> seller terverifikasi di platform.</p>
                </div>
                
                <div class="flex gap-3">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" x-model="search" placeholder="Cari nama toko..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none w-64 shadow-sm">
                        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                    </div>

                    <!-- Filter Status -->
                    <select x-model="filterStatus" class="border border-gray-300 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-sm font-bold text-gray-600">
                        <option value="all">Semua Status</option>
                        <option value="verified">Verified</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
            </div>

            <!-- TABEL TOKO (DINAMIS) -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-orange-50/50 text-gray-400 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Nama Toko</th>
                                <th class="px-6 py-5">Pemilik</th>
                                <th class="px-6 py-5">Saldo</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            <template x-for="store in filteredStores" :key="store.id">
                                <tr class="hover:bg-orange-50/30 transition group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl shadow-sm" :class="store.bg">
                                                <span x-text="store.icon"></span>
                                            </div>
                                            <div>
                                                <span class="block font-bold text-gray-800 text-base" x-text="store.name"></span>
                                                <span class="text-xs text-gray-400" x-text="store.location"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="font-bold text-gray-600" x-text="store.owner"></span>
                                        <span class="block text-xs text-gray-400" x-text="store.email"></span>
                                    </td>
                                    <td class="px-6 py-5 font-mono font-bold" :class="store.balance > 0 ? 'text-green-600' : 'text-gray-400'" x-text="formatRupiah(store.balance)"></td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                                              :class="store.status === 'verified' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                              x-text="store.status === 'verified' ? 'Verified' : 'Suspended'">
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <button @click="openDetail(store)" class="text-blue-600 hover:text-blue-800 font-bold text-xs border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition mr-1">
                                            Detail
                                        </button>
                                        <button @click="toggleStatus(store)" 
                                                class="font-bold text-xs border px-3 py-1.5 rounded-lg transition"
                                                :class="store.status === 'verified' ? 'text-red-600 border-red-200 hover:bg-red-50' : 'text-green-600 border-green-200 hover:bg-green-50'"
                                                x-text="store.status === 'verified' ? 'Suspend' : 'Aktifkan'">
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty State -->
                            <tr x-show="filteredStores.length === 0">
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400">
                                    Tidak ada toko yang ditemukan.
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            
        </main>

        <!-- MODAL DETAIL TOKO -->
        <div x-show="selectedStore" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="selectedStore = null" class="bg-white rounded-[2rem] w-full max-w-lg p-8 shadow-2xl relative border-4 border-orange-100">
                <button @click="selectedStore = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 font-bold bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">✕</button>

                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center text-4xl shadow-md mb-4" :class="selectedStore?.bg">
                        <span x-text="selectedStore?.icon"></span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900" x-text="selectedStore?.name"></h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold mt-2 inline-block"
                          :class="selectedStore?.status === 'verified' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                          x-text="selectedStore?.status === 'verified' ? 'Status: Verified' : 'Status: Suspended'">
                    </span>
                </div>

                <div class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Pemilik</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.owner"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Email</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.email"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Lokasi</span>
                        <span class="font-bold text-gray-800" x-text="selectedStore?.location"></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500 text-sm">Total Saldo</span>
                        <span class="font-mono font-bold text-green-600" x-text="formatRupiah(selectedStore?.balance)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Bergabung Sejak</span>
                        <span class="font-bold text-gray-800">12 Des 2024</span>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button @click="deleteStore(selectedStore.id)" class="flex-1 bg-red-100 text-red-600 font-bold py-3 rounded-xl hover:bg-red-200 transition">
                        Hapus Permanen
                    </button>
                    <button @click="selectedStore = null" class="flex-1 bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT LOGIC -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('storeManager', () => ({
                search: '',
                filterStatus: 'all',
                selectedStore: null,
                
                // DATA DUMMY (NAMA TOKO PROFESIONAL)
                stores: [
                    { id: 1, name: 'Teddy House Official', owner: 'Rina Nose', email: 'rina@teddyhouse.com', location: 'Malang, ID', balance: 1200000, status: 'verified', icon: '🧸', bg: 'bg-orange-100' },
                    { id: 2, name: 'Cuddle Corner', owner: 'Joko Anwar', email: 'joko@cuddle.co.id', location: 'Surabaya, ID', balance: 450000, status: 'verified', icon: '🧶', bg: 'bg-blue-100' },
                    { id: 3, name: 'Kids Station Bandung', owner: 'Budi Santoso', email: 'budi@kidsstation.com', location: 'Bandung, ID', balance: 0, status: 'suspended', icon: '🚫', bg: 'bg-red-100' },
                    { id: 4, name: 'Doll Fashionista', owner: 'Siti Badriah', email: 'siti@fashion.com', location: 'Jakarta, ID', balance: 8500000, status: 'verified', icon: '👗', bg: 'bg-pink-100' },
                    { id: 5, name: 'Accessories Kingdom', owner: 'Raffi Ahmad', email: 'raffi@kingdom.com', location: 'Medan, ID', balance: 250000, status: 'verified', icon: '👑', bg: 'bg-yellow-100' },
                ],

                // Filter Logic
                get filteredStores() {
                    return this.stores.filter(store => {
                        const matchesSearch = store.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                              store.owner.toLowerCase().includes(this.search.toLowerCase());
                        const matchesStatus = this.filterStatus === 'all' || store.status === this.filterStatus;
                        return matchesSearch && matchesStatus;
                    });
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number || 0);
                },

                openDetail(store) {
                    this.selectedStore = store;
                },

                toggleStatus(store) {
                    // Simulasi update status
                    store.status = store.status === 'verified' ? 'suspended' : 'verified';
                },

                deleteStore(id) {
                    if(confirm('Apakah Anda yakin ingin menghapus toko ini secara permanen? Data tidak bisa dikembalikan.')) {
                        this.stores = this.stores.filter(s => s.id !== id);
                        this.selectedStore = null;
                        alert('Toko berhasil dihapus.');
                    }
                }
            }));
        });
    </script>

</body>
</html>