<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Belanja - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
        .timeline-line { position: absolute; left: 15px; top: 30px; bottom: 0; width: 2px; background: #e5e7eb; z-index: 0; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 h-16 flex items-center px-6 sticky top-0 z-50">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <span class="text-3xl">🧸</span>
            <span class="font-extrabold text-gray-800 text-xl">My Orders</span>
        </a>
        <div class="ml-auto flex gap-4 text-sm font-bold">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600">Home</a>
            <a href="{{ route('wardrobe') }}" class="text-gray-500 hover:text-orange-600">Inventory</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6 md:p-10" 
         x-data="{ 
            activeTab: 'all', // all, dikirim, selesai
            showTrackModal: false,
            showReviewModal: false,
            selectedOrder: null,
            rating: 0,
            
            // Data Dummy Pesanan
            orders: [
                { 
                    id: 'TRX-88291', date: '22 Des 2025', total: 175000, status: 'dikirim', resi: 'JP1234567890',
                    items: [ { name: 'Custom Teddy (Coklat)', desc: '+ Kaos Merah & Kacamata' } ]
                },
                { 
                    id: 'TRX-11029', date: '10 Des 2025', total: 55000, status: 'selesai', resi: 'JP9876543210',
                    items: [ { name: 'Hoodie Biru', desc: 'Size: M' } ],
                    review: null // Belum direview
                }
            ],

            confirmReceive(orderId) {
                if(confirm('Apakah Anda yakin pesanan sudah diterima dengan baik?')) {
                    // Update status dummy ke 'selesai'
                    let order = this.orders.find(o => o.id === orderId);
                    if(order) order.status = 'selesai';
                    alert('Pesanan selesai! Silakan beri nilai.');
                }
            },

            submitReview() {
                alert('Terima kasih atas penilaian Anda! ⭐' + this.rating);
                this.showReviewModal = false;
                // Logic backend: Simpan review ke DB
            }
         }">

        <!-- Header & Filter Status -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-extrabold text-gray-800">Pesanan Saya 📦</h1>
            <div class="flex bg-white p-1 rounded-xl shadow-sm border border-gray-200">
                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:bg-gray-50'" class="px-4 py-2 rounded-lg text-sm font-bold transition">Semua</button>
                <button @click="activeTab = 'dikirim'" :class="activeTab === 'dikirim' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:bg-gray-50'" class="px-4 py-2 rounded-lg text-sm font-bold transition">Dikirim</button>
                <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:bg-gray-50'" class="px-4 py-2 rounded-lg text-sm font-bold transition">Selesai</button>
            </div>
        </div>

        <!-- LIST PESANAN -->
        <div class="space-y-6">
            <template x-for="order in orders" :key="order.id">
                <div x-show="activeTab === 'all' || activeTab === order.status" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    
                    <!-- Header Kartu -->
                    <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1" x-text="order.date"></p>
                            <p class="font-bold text-gray-800" x-text="'Order #' + order.id"></p>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            <span x-show="order.status === 'dikirim'" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                🚚 Sedang Dikirim
                            </span>
                            <span x-show="order.status === 'selesai'" class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                ✅ Pesanan Selesai
                            </span>
                        </div>
                    </div>

                    <!-- Item Detail -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-orange-50 rounded-xl flex items-center justify-center text-3xl">🧸</div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800" x-text="order.items[0].name"></h4>
                            <p class="text-xs text-gray-500" x-text="order.items[0].desc"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-400">Total Belanja</p>
                            <p class="font-extrabold text-orange-600" x-text="'Rp ' + order.total.toLocaleString('id-ID')"></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        
                        <!-- Tombol Lacak (Muncul kalau dikirim/selesai) -->
                        <button @click="selectedOrder = order; showTrackModal = true" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition">
                            📍 Lacak Paket
                        </button>

                        <!-- Tombol Terima (Hanya kalau status dikirim) -->
                        <button x-show="order.status === 'dikirim'" @click="confirmReceive(order.id)" class="px-6 py-2 bg-orange-600 text-white rounded-xl text-sm font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                            Pesanan Diterima
                        </button>

                        <!-- Tombol Review (Hanya kalau selesai) -->
                        <button x-show="order.status === 'selesai'" @click="selectedOrder = order; showReviewModal = true" class="px-6 py-2 border-2 border-orange-500 text-orange-600 rounded-xl text-sm font-bold hover:bg-orange-50 transition">
                            ⭐ Beri Nilai
                        </button>
                    </div>

                </div>
            </template>
        </div>

        <!-- MODAL 1: LACAK PAKET -->
        <div x-show="showTrackModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="showTrackModal = false" class="bg-white rounded-[2rem] w-full max-w-md p-6 shadow-2xl relative">
                <button @click="showTrackModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>
                
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Status Pengiriman</h3>
                <p class="text-sm text-gray-500 mb-6">Resi: <span class="font-mono font-bold text-orange-600" x-text="selectedOrder?.resi"></span></p>

                <!-- Timeline -->
                <div class="relative space-y-6 pl-2">
                    <div class="timeline-line"></div>
                    
                    <!-- Step 1 -->
                    <div class="relative flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center z-10 text-xs shadow">✓</div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Paket Diterima Kurir</p>
                            <p class="text-xs text-gray-500">Malang Gateway • 09:30 WIB</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="relative flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center z-10 text-xs shadow">✓</div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Sedang Dikirim ke Kota Tujuan</p>
                            <p class="text-xs text-gray-500">Transit Surabaya • 14:00 WIB</p>
                        </div>
                    </div>
                    <!-- Step 3 (Aktif) -->
                    <div class="relative flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center z-10 text-xs shadow animate-pulse">🚚</div>
                        <div>
                            <p class="text-sm font-bold text-orange-600">Kurir Mengantar ke Alamatmu</p>
                            <p class="text-xs text-gray-500">Estimasi tiba hari ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL 2: BERI ULASAN -->
        <div x-show="showReviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="showReviewModal = false" class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl relative text-center">
                
                <h3 class="text-2xl font-extrabold text-gray-800 mb-2">Bagaimana Produknya?</h3>
                <p class="text-gray-500 text-sm mb-6">Beri bintang untuk pesanan <span x-text="'#' + selectedOrder?.id" class="font-bold"></span></p>

                <!-- Bintang Rating -->
                <div class="flex justify-center gap-2 mb-6">
                    <template x-for="i in 5">
                        <button @click="rating = i" class="text-4xl transition transform hover:scale-110 focus:outline-none" :class="i <= rating ? 'text-yellow-400' : 'text-gray-200'">★</button>
                    </template>
                </div>

                <textarea class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-orange-500 outline-none mb-4" rows="3" placeholder="Ceritakan pengalamanmu... (Kualitas bahan, jahitan, dll)"></textarea>

                <div class="flex gap-3">
                    <button @click="showReviewModal = false" class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition">Batal</button>
                    <button @click="submitReview()" class="flex-1 py-3 bg-orange-600 text-white font-bold rounded-xl shadow-lg hover:bg-orange-700 transition">Kirim Ulasan</button>
                </div>

            </div>
        </div>

    </div>
</body>
</html>