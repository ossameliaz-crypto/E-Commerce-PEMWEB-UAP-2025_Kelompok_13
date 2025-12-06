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

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 py-4 px-6 flex justify-between items-center z-50">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <h1 class="text-xl font-bold text-gray-700">Keranjang Saya</h1>
        </div>
        <a href="{{ url('/') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600">Kembali ke Toko</a>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col relative overflow-hidden"
         x-data="{ 
            // DATA BARANG DI KERANJANG (Simulasi Backend)
            cartItems: [
                { id: 1, name: 'Teddy Coklat M', price: 150000, type: 'base', image: '🐻', color: '#8B4513' },
                { id: 2, name: 'Kaos Merah', price: 50000, type: 'outfit', image: '👕' },
                { id: 3, name: 'Kacamata', price: 25000, type: 'acc', image: '👓' }
            ],
            selectedItems: [], // Array ID barang yang dipilih

            get totalSelected() {
                return this.cartItems
                    .filter(item => this.selectedItems.includes(item.id))
                    .reduce((sum, item) => sum + item.price, 0);
            },

            toggleSelectAll() {
                if (this.selectedItems.length === this.cartItems.length) {
                    this.selectedItems = [];
                } else {
                    this.selectedItems = this.cartItems.map(item => item.id);
                }
            }
         }">

        <!-- LIST ITEM (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-6 pb-32">
            <div class="max-w-4xl mx-auto space-y-4">
                
                <!-- Header List -->
                <div class="flex items-center justify-between mb-4 px-2">
                    <label class="flex items-center gap-3 cursor-pointer text-sm font-bold text-gray-600">
                        <input type="checkbox" @click="toggleSelectAll()" :checked="selectedItems.length > 0 && selectedItems.length === cartItems.length" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300">
                        Pilih Semua
                    </label>
                    <button class="text-red-500 text-xs font-bold hover:underline">Hapus</button>
                </div>

                <!-- EMPTY STATE -->
                <div x-show="cartItems.length === 0" class="text-center py-20">
                    <div class="text-6xl mb-4">🛒</div>
                    <h2 class="text-xl font-bold text-gray-400">Keranjang Kosong</h2>
                    <a href="{{ route('workshop') }}" class="mt-4 inline-block bg-orange-600 text-white px-6 py-2 rounded-full font-bold">Belanja Sekarang</a>
                </div>

                <!-- ITEM CARDS -->
                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
                        
                        <!-- Checkbox -->
                        <input type="checkbox" :value="item.id" x-model="selectedItems" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300 cursor-pointer">
                        
                        <!-- Gambar -->
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center text-4xl bg-gray-50 border border-gray-100" :style="item.color ? 'background-color:'+item.color : ''">
                            <span x-text="item.image"></span>
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-lg" x-text="item.name"></h3>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider" x-text="item.type"></p>
                            <p class="text-orange-600 font-extrabold mt-1" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></p>
                        </div>

                        <!-- Qty (Simpel) -->
                        <div class="text-gray-400 font-bold text-sm">x1</div>
                    </div>
                </template>

            </div>
        </div>

        <!-- BOTTOM BAR (Sticky Checkout) -->
        <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40">
            <div class="max-w-4xl mx-auto flex justify-between items-center">
                
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400 font-bold uppercase">Total Pilihan</span>
                    <span class="text-2xl font-extrabold text-orange-600" x-text="'Rp ' + totalSelected.toLocaleString('id-ID')"></span>
                </div>

                <!-- Tombol Checkout -->
                <form action="{{ route('checkout') }}" method="GET">
                    <!-- Kirim ID barang yang dipilih ke backend -->
                    <input type="hidden" name="selected_items" :value="selectedItems">
                    
                    <button type="submit" 
                            :disabled="selectedItems.length === 0"
                            :class="selectedItems.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-orange-600 hover:bg-orange-700 shadow-lg hover:shadow-orange-500/40 transform hover:-translate-y-1'"
                            class="text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2">
                        Checkout <span x-text="'(' + selectedItems.length + ')'"></span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>