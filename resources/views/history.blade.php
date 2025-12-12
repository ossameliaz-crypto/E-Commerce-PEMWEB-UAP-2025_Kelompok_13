<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Belanja - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: #FFFBF5;
            background-image: radial-gradient(#FDBA74 1px, transparent 1px);
            background-size: 24px 24px;
        }
        [x-cloak] { display: none !important; }
        
        .timeline-line { 
            position: absolute; 
            left: 19px; 
            top: 35px; 
            bottom: 10px; 
            width: 2px; 
            background: #E5E7EB; 
            z-index: 0; 
        }
        
        /* Smooth Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #fed7aa; border-radius: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>
    <script>
        window.formatRupiah = (angka) => {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        };
    </script>
</head>
<body class="text-gray-700 min-h-screen">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-orange-100 py-4 shadow-sm transition-all duration-300">
        <div class="max-w-5xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <span class="text-3xl bg-orange-50 p-1.5 rounded-xl border border-orange-100 group-hover:scale-110 transition">🧸</span>
                <div>
                    <h1 class="text-lg font-black text-gray-800 tracking-tight leading-none">My Orders</h1>
                    <p class="text-xs text-gray-400 font-bold group-hover:text-orange-500 transition">Riwayat Belanja</p>
                </div>
            </a>
            <div class="flex gap-6 text-sm font-bold text-gray-500">
                <a href="{{ url('/') }}" class="hover:text-orange-600 transition">Home</a>
                <a href="{{ url('/wardrobe') }}" class="hover:text-orange-600 transition">Inventory</a>
            </div>
        </div>
    </nav>

    <div class="pt-28 pb-20 px-4 max-w-4xl mx-auto" 
         x-data="{ 
            activeTab: 'all', 
            showTrackModal: false,
            showReviewModal: false,
            selectedOrder: null,
            rating: 0,
            
            // --- DATA DUMMY (Tanpa DB) ---
            orders: [
                { 
                    id: 'ORD-882190', 
                    date: 'Hari ini, 14:30', 
                    total: 198000, 
                    status: 'dikirim', 
                    resi: 'JP-882910022',
                    item_name: 'Custom Teddy (Honey)',
                    item_desc: 'Hoodie Merah + Kacamata',
                    item_img: '🐻'
                },
                { 
                    id: 'ORD-771029', 
                    date: '20 Des 2025', 
                    total: 155000, 
                    status: 'selesai', 
                    resi: 'JP-110293844',
                    item_name: 'Panda Bear (S)',
                    item_desc: 'Basic (Tanpa Aksesoris)',
                    item_img: '🐼'
                },
                { 
                    id: 'ORD-552100', 
                    date: '10 Nov 2025', 
                    total: 250000, 
                    status: 'selesai', 
                    resi: 'JP-551239911',
                    item_name: 'Polar Bear (L)',
                    item_desc: 'Syal Musim Dingin',
                    item_img: '🐻‍❄️'
                }
            ],

            // Helper untuk warna status
            getStatusColor(status) {
                if(status === 'dikirim') return 'bg-blue-50 text-blue-600 border-blue-100';
                if(status === 'selesai') return 'bg-green-50 text-green-600 border-green-100';
                return 'bg-gray-100 text-gray-600';
            },

            getStatusLabel(status) {
                if(status === 'dikirim') return 'Sedang Dikirim 🚚';
                if(status === 'selesai') return 'Pesanan Selesai ✅';
                return status;
            },

            confirmReceive(orderId) {
                if(confirm('Yakin pesanan sudah sampai dan sesuai?')) {
                    // Update dummy status
                    let order = this.orders.find(o => o.id === orderId);
                    if(order) order.status = 'selesai';
                    alert('Status berhasil diperbarui!');
                }
            },

            submitReview() {
                alert('Terima kasih! Bintang ' + this.rating + ' telah dikirim ⭐');
                this.showReviewModal = false;
                this.rating = 0;
            }
         }">

        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-gray-800 mb-2">Kotak Pesanan 📦</h2>
            <p class="text-gray-500 font-medium">Lacak perjalanan teman barumu ke rumah.</p>
        </div>

        <div class="flex justify-center mb-8">
            <div class="bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100 inline-flex">
                <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-orange-500 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50'" 
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Semua
                </button>
                <button @click="activeTab = 'dikirim'" 
                        :class="activeTab === 'dikirim' ? 'bg-orange-500 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50'" 
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Dikirim
                </button>
                <button @click="activeTab = 'selesai'" 
                        :class="activeTab === 'selesai' ? 'bg-orange-500 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50'" 
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Selesai
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <template x-for="order in orders" :key="order.id">
                <div x-show="activeTab === 'all' || activeTab === order.status" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-white rounded-[2rem] p-6 md:p-8 shadow-xl shadow-orange-100/30 border border-white hover:border-orange-200 hover:-translate-y-1 transition duration-300 relative group overflow-hidden">
                    
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-[4rem] -z-0 opacity-50 group-hover:scale-110 transition duration-500"></div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-dashed border-gray-100 pb-4 relative z-10">
                        <div class="flex items-center gap-3 mb-2 md:mb-0">
                            <div class="bg-gray-100 p-2 rounded-lg text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider" x-text="order.date"></p>
                                <p class="font-black text-gray-800 text-lg" x-text="order.id"></p>
                            </div>
                        </div>
                        
                        <span class="px-4 py-1.5 rounded-full text-xs font-black border flex items-center gap-2 shadow-sm" :class="getStatusColor(order.status)">
                            <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                            <span x-text="getStatusLabel(order.status)"></span>
                        </span>
                    </div>

                    <div class="flex items-center gap-5 mb-6 relative z-10">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-white rounded-2xl flex items-center justify-center text-4xl shadow-inner border border-orange-100" x-text="order.item_img"></div>
                        
                        <div class="flex-1">
                            <h4 class="font-black text-gray-800 text-lg leading-tight" x-text="order.item_name"></h4>
                            <p class="text-sm text-gray-500 font-medium mt-1" x-text="order.item_desc"></p>
                        </div>
                        
                        <div class="text-right hidden md:block">
                            <p class="text-xs text-gray-400 font-bold uppercase">Total Bayar</p>
                            <p class="font-black text-xl text-orange-600" x-text="formatRupiah(order.total)"></p>
                        </div>
                    </div>
                    
                    <div class="md:hidden flex justify-between items-center mb-6 pt-2 border-t border-dashed border-gray-100">
                        <p class="text-sm text-gray-500 font-bold">Total</p>
                        <p class="font-black text-lg text-orange-600" x-text="formatRupiah(order.total)"></p>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3 pt-2 relative z-10">
                        
                        <button @click="selectedOrder = order; showTrackModal = true" 
                                class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-100 hover:text-gray-800 transition flex items-center gap-2 border border-transparent hover:border-gray-200">
                            <span>📍</span> Lacak
                        </button>

                        <button x-show="order.status === 'dikirim'" 
                                @click="confirmReceive(order.id)" 
                                class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 hover:shadow-lg hover:-translate-y-0.5 transition flex items-center gap-2">
                            <span>📦</span> Pesanan Diterima
                        </button>

                        <button x-show="order.status === 'selesai'" 
                                @click="selectedOrder = order; showReviewModal = true" 
                                class="px-6 py-2.5 bg-white border-2 border-orange-100 text-orange-500 rounded-xl text-sm font-bold hover:border-orange-500 hover:bg-orange-50 transition flex items-center gap-2">
                            <span>⭐</span> Beri Ulasan
                        </button>
                    </div>

                </div>
            </template>
            
            <div x-show="orders.length === 0" class="text-center py-20 bg-white rounded-[2rem] shadow-sm border border-gray-100">
                <div class="text-6xl mb-4 grayscale opacity-50">🧸</div>
                <h3 class="text-xl font-bold text-gray-600">Belum ada pesanan</h3>
                <p class="text-gray-400 text-sm mt-1">Yuk buat Teddy pertamamu sekarang!</p>
            </div>
        </div>

        <div x-show="showTrackModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-orange-900/20 backdrop-blur-sm" x-cloak x-transition.opacity>
            <div @click.away="showTrackModal = false" class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative overflow-hidden" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                
                <button @click="showTrackModal = false" class="absolute top-6 right-6 text-gray-300 hover:text-gray-600 transition text-xl font-bold">✕</button>
                
                <h3 class="text-2xl font-black text-gray-800 mb-1">Lacak Paket 🚚</h3>
                <div class="flex items-center gap-2 mb-8">
                    <span class="text-xs font-bold text-gray-400 uppercase">Resi:</span>
                    <span class="font-mono font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded select-all" x-text="selectedOrder?.resi"></span>
                </div>

                <div class="relative space-y-8 pl-4 ml-2">
                    <div class="timeline-line"></div>
                    
                    <div class="relative flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 border-4 border-white flex items-center justify-center z-10 text-sm font-bold shadow-sm">✓</div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Paket Diterima Kurir</p>
                            <p class="text-xs text-gray-500 mt-0.5">Malang Gateway • 09:30 WIB</p>
                        </div>
                    </div>
                    <div class="relative flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 border-4 border-white flex items-center justify-center z-10 text-sm font-bold shadow-sm">✓</div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Transit Hub Surabaya</p>
                            <p class="text-xs text-gray-500 mt-0.5">Sedang disortir • 14:00 WIB</p>
                        </div>
                    </div>
                    <div class="relative flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white border-4 border-orange-200 flex items-center justify-center z-10 text-lg shadow-lg animate-pulse">🚚</div>
                        <div>
                            <p class="font-bold text-orange-600 text-sm">Menuju Alamatmu</p>
                            <p class="text-xs text-gray-500 mt-0.5">Kurir sedang dalam perjalanan</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <button @click="showTrackModal = false" class="text-sm font-bold text-gray-400 hover:text-gray-600">Tutup</button>
                </div>
            </div>
        </div>

        <div x-show="showReviewModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-orange-900/20 backdrop-blur-sm" x-cloak x-transition.opacity>
            <div @click.away="showReviewModal = false" class="bg-white rounded-[2.5rem] w-full max-w-sm p-8 shadow-2xl relative text-center"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                
                <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center text-4xl mx-auto mb-4 border-4 border-white shadow-sm">⭐</div>
                
                <h3 class="text-2xl font-black text-gray-800 mb-2">Suka Produknya?</h3>
                <p class="text-gray-500 text-sm mb-6">Beri bintang untuk pesanan <span x-text="'#' + selectedOrder?.id" class="font-bold text-gray-700"></span></p>

                <div class="flex justify-center gap-2 mb-6">
                    <template x-for="i in 5">
                        <button @click="rating = i" class="text-4xl transition transform hover:scale-125 hover:rotate-6 focus:outline-none" :class="i <= rating ? 'text-yellow-400 drop-shadow-sm' : 'text-gray-200'">★</button>
                    </template>
                </div>

                <textarea class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-sm focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none mb-6 transition resize-none" rows="3" placeholder="Ceritakan pengalamanmu..."></textarea>

                <div class="flex gap-3">
                    <button @click="showReviewModal = false" class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition text-sm">Nanti Saja</button>
                    <button @click="submitReview()" class="flex-1 py-3 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:bg-gray-800 hover:shadow-xl transition text-sm">Kirim</button>
                </div>

            </div>
        </div>

    </div>
</body>
</html>