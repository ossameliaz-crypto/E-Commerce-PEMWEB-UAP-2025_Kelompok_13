<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Saya - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Nunito', sans-serif; } [x-cloak] { display: none; } </style>
</head>
<body class="bg-gray-50 flex flex-col h-screen overflow-hidden">

    <!-- 1. PRE-PROCESS DATA DARI BACKEND -->
    @php
        // Ambil data $carts yang dikirim dari CartController
        // Jika belum ada data, gunakan koleksi kosong agar tidak error
        $rawCarts = isset($carts) ? $carts : collect([]);

        // Kita ubah format data Database menjadi format yang dimengerti JavaScript (JSON)
        $formattedData = $rawCarts->map(function($item) {
            // Tentukan Ikon
            $icon = '🧸';
            if($item->base_model == 'panda') $icon = '🐼';
            
            // Tentukan Warna Background
            $color = '#8B4513';
            if($item->base_model == 'krem') $color = '#F5DEB3';
            if($item->base_model == 'panda') $color = '#333';

            // Buat Deskripsi Singkat Fitur
            $features = [];
            if($item->outfit_id) $features[] = 'Baju';
            if($item->accessory_id) $features[] = 'Acc';
            if($item->voice_type && $item->voice_type != 'none') $features[] = 'Suara';
            if($item->scent_type && $item->scent_type != 'none') $features[] = 'Wangi';
            
            $typeDesc = !empty($features) ? implode(' + ', $features) : 'Basic Doll';

            return [
                'id' => $item->id,
                'name' => ucfirst($item->base_model) . ' Bear (' . $item->size . ')',
                'price' => $item->total_price,
                'type' => $typeDesc,
                'image' => $icon,
                'color' => $color,
                // Tandai 'Custom' jika ada rekaman suara atau gift box
                'custom' => ($item->voice_type == 'record' || $item->gift_box != 'none') ? true : false
            ];
        });
    @endphp

    <!-- 2. NAVBAR -->
    <nav class="bg-white border-b border-gray-200 py-4 px-6 flex justify-between items-center z-50">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <h1 class="text-xl font-bold text-gray-700">Keranjang Saya</h1>
        </div>
        <div class="flex gap-4 items-center">
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600">Dashboard</a>
            <a href="{{ url('/') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600">Home</a>
        </div>
    </nav>

    <!-- 3. MAIN CONTENT -->
    <div class="flex-1 flex flex-col relative overflow-hidden"
         x-data="{ 
            // [PENTING] Masukkan data yang sudah diformat PHP ke variabel JS
            cartItems: {{ Js::from($formattedData) }},
            
            selectedItems: [], 

            get totalSelected() {
                return this.cartItems
                    .filter(item => this.selectedItems.includes(item.id))
                    .reduce((sum, item) => sum + parseFloat(item.price), 0);
            },

            toggleSelectAll() {
                if (this.selectedItems.length === this.cartItems.length) {
                    this.selectedItems = [];
                } else {
                    this.selectedItems = this.cartItems.map(item => item.id);
                }
            },

            formatRupiah(angka) {
                return 'Rp ' + Number(angka).toLocaleString('id-ID');
            }
         }">

        <!-- LIST ITEM (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-6 pb-32">
            <div class="max-w-4xl mx-auto space-y-4">
                
                <!-- Header List -->
                <div x-show="cartItems.length > 0" class="flex items-center justify-between mb-4 px-2">
                    <label class="flex items-center gap-3 cursor-pointer text-sm font-bold text-gray-600">
                        <input type="checkbox" @click="toggleSelectAll()" :checked="selectedItems.length > 0 && selectedItems.length === cartItems.length" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300">
                        Pilih Semua
                    </label>
                    <span class="text-xs text-gray-400 font-bold" x-text="cartItems.length + ' Barang'"></span>
                </div>

                <!-- EMPTY STATE (Muncul jika database kosong) -->
                <div x-show="cartItems.length === 0" class="flex flex-col items-center justify-center h-full py-20 text-center" x-cloak>
                    <div class="w-40 h-40 bg-orange-50 rounded-full flex items-center justify-center mb-6">
                        <span class="text-7xl opacity-50 grayscale">🛒</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Keranjang Masih Kosong</h2>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                        Wah, sepertinya kamu belum mengadopsi boneka apapun. Yuk cari teman barumu di Workshop sekarang!
                    </p>
                    <a href="{{ route('workshop') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30 hover:scale-105 transition transform">
                        <span>🚀</span> Mulai Belanja
                    </a>
                </div>

                <!-- ITEM CARDS (Looping Data Asli) -->
                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
                        
                        <!-- Checkbox -->
                        <input type="checkbox" :value="item.id" x-model="selectedItems" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300 cursor-pointer">
                        
                        <!-- Gambar (Warna Dinamis dari DB) -->
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center text-4xl bg-gray-50 border border-gray-100 shrink-0" 
                             :style="'background-color:' + item.color">
                            <span x-text="item.image"></span>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-800 text-lg truncate" x-text="item.name"></h3>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider" x-text="item.type"></p>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                <p class="text-orange-600 font-extrabold" x-text="formatRupiah(item.price)"></p>
                                <!-- Badge Custom -->
                                <span x-show="item.custom" class="text-[10px] bg-purple-100 text-purple-600 px-2 py-0.5 rounded font-bold">Custom</span>
                            </div>
                        </div>

                        <!-- Tombol Hapus (Dummy UI) -->
                        <button class="text-gray-300 hover:text-red-500 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </template>

            </div>
        </div>

        <!-- BOTTOM BAR (Hanya muncul jika ada barang) -->
        <div x-show="cartItems.length > 0" class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40" x-transition>
            <div class="max-w-4xl mx-auto flex justify-between items-center">
                
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400 font-bold uppercase">Total Pilihan</span>
                    <span class="text-2xl font-extrabold text-orange-600" x-text="formatRupiah(totalSelected)"></span>
                </div>

                <!-- Tombol Checkout -->
                <form action="{{ route('checkout') }}" method="GET">
                    <!-- Kirim ID barang yang dipilih -->
                    <template x-for="id in selectedItems">
                        <input type="hidden" name="selected_ids[]" :value="id">
                    </template>
                    
                    <button type="submit" 
                            :disabled="selectedItems.length === 0"
                            :class="selectedItems.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-orange-600 hover:bg-orange-700 shadow-lg hover:shadow-orange-500/40 transform hover:-translate-y-1'"
                            class="text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2">
                        Checkout <span x-text="selectedItems.length > 0 ? '(' + selectedItems.length + ')' : ''"></span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>