<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; } 
        [x-cloak] { display: none; } 
        .font-display { font-family: 'Fredoka', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: { 50: '#fff7ed', 600: '#ea580c' },
                        red: { 500: '#ef4444' }
                    }
                }
            }
        }
        
        // **INIT GLOBAL ALPINE STORE FOR MODAL**
        document.addEventListener('alpine:init', () => {
            Alpine.store('wardrobeModal', {
                isModalOpen: false,
                activeItem: null,
                openDetail(item) {
                    this.activeItem = item;
                    this.isModalOpen = true;
                },
                closeDetail() {
                    this.isModalOpen = false;
                    setTimeout(() => { this.activeItem = null; }, 300);
                }
            });
        });
        
        // Memastikan formatRupiah ada secara global untuk digunakan di modal
        window.formatRupiah = (angka) => {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        };
    </script>
</head>
<body class="bg-orange-50 flex flex-col h-screen overflow-hidden">

    @php
        $rawCarts = isset($carts) ? $carts : collect([]);

        $formattedData = $rawCarts->map(function($item) {
            $icon = '🧸';
            if($item->base_model == 'panda') $icon = '🐼';
            
            $color = '#FFD4AA';
            if($item->base_model == 'krem') $color = '#FFECC5';
            if($item->base_model == 'panda') $color = '#D1D5DB';

            $features = [];
            if($item->outfit_id) $features[] = 'Baju';
            if($item->accessory_id) $features[] = 'Acc';
            if($item->voice_type && $item->voice_type != 'none') $features[] = 'Suara';
            if($item->scent_type && $item->scent_type != 'none') $features[] = 'Wangi';
            
            $typeDesc = !empty($features) ? implode(' + ', $features) : 'Basic Doll';

            return [
                'id' => $item->id,
                'name' => ucfirst($item->base_model) . ' Bear',
                'size' => $item->size,
                // Pastikan harga di-cast ke numerik
                'price' => (int) $item->total_price, 
                'type' => $typeDesc,
                'image' => $icon,
                'color' => $color,
                'custom' => ($item->voice_type == 'record' || $item->gift_box != 'none'),
                
                'details' => [
                    'base_model' => ucfirst($item->base_model),
                    'outfit' => $item->outfit_id ?? 'None',
                    'accessory' => $item->accessory_id ?? 'None',
                    'voice' => $item->voice_type ?? 'None',
                    'scent' => $item->scent_type ?? 'None',
                    'gift_box' => $item->gift_box ?? 'None',
                    'message' => $item->card_message ?? 'Tidak ada pesan',
                ]
            ];
        });
    @endphp
    
    <div x-data="{ modal: Alpine.store('wardrobeModal') }" x-show="modal.isModalOpen" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="modal.isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="modal.closeDetail()"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div x-show="modal.isModalOpen" x-transition.scale class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all w-full max-w-2xl border-4 border-orange-100">
                
                <button @click="modal.closeDetail()" class="absolute top-4 right-4 z-10 p-2 bg-gray-100 hover:bg-gray-200 rounded-full transition text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="p-8">
                    <h2 class="text-3xl font-display font-extrabold text-gray-800 mb-6">Detail Kustomisasi</h2>
                    
                    <template x-if="modal.activeItem">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-orange-50 rounded-xl">
                                <span x-text="modal.activeItem.image" class="text-4xl"></span>
                                <div>
                                    <h3 class="font-display font-bold text-gray-800 text-xl" x-text="modal.activeItem.name + ' (' + modal.activeItem.size + ')'"></h3>
                                    <p class="text-sm text-orange-600 font-bold" x-text="formatRupiah(modal.activeItem.price)"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm font-bold text-gray-700 max-h-60 overflow-y-auto">
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Model Dasar</p>
                                    <p x-text="modal.activeItem.details.base_model"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Ukuran</p>
                                    <p x-text="modal.activeItem.size"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Outfit</p>
                                    <p x-text="modal.activeItem.details.outfit"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Aksesoris</p>
                                    <p x-text="modal.activeItem.details.accessory"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Suara</p>
                                    <p x-text="modal.activeItem.details.voice"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase">Aroma</p>
                                    <p x-text="modal.activeItem.details.scent"></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 col-span-2">
                                    <p class="text-xs text-gray-500 uppercase">Pesan Kartu Ucapan</p>
                                    <p x-text="modal.activeItem.details.message"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div class="mt-8 text-right">
                        <button @click="modal.closeDetail()" class="bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-md hover:bg-orange-700 transition">Selesai</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <nav class="bg-white border-b border-orange-100 py-4 px-8 flex justify-between items-center z-50 shadow-md">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <h1 class="text-2xl font-display font-extrabold text-gray-800">Keranjang Saya</h1>
        </div>
        <div class="flex gap-6 items-center">
            <a href="{{ route('workshop') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600 px-3 py-1 rounded-md hover:bg-orange-50 transition">Workshop</a>
            <a href="{{ url('/') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600 px-3 py-1 rounded-md hover:bg-orange-50 transition">Home</a>
        </div>
    </nav>

    <div class="flex-1 flex flex-col relative overflow-hidden"
            x-data="{ 
                cartItems: {{ Js::from($formattedData) }},
                selectedItems: [], 
                
                get totalSelected() {
                    // FIX KRITIS: Memastikan nilai price dikonversi ke numerik
                    return this.cartItems
                        .filter(item => this.selectedItems.includes(item.id))
                        .reduce((sum, item) => sum + (Number(item.price) || 0), 0);
                },

                // Menghapus logic Voucher/Diskon karena fiturnya dihapus
                
                toggleSelectAll() {
                    if (this.selectedItems.length === this.cartItems.length) {
                        this.selectedItems = [];
                    } else {
                        this.selectedItems = this.cartItems.map(item => item.id);
                    }
                },

                // === FUNGSI HAPUS ITEM TUNGGAL ===
                deleteItem(itemId) {
                    if (window.confirm('Yakin ingin menghapus item ini dari keranjang? Tindakan ini tidak bisa dibatalkan.')) {
                        const form = document.getElementById(`delete-form-${itemId}`);
                        form.action = form.action.replace('TEMP_ID', itemId);
                        form.submit();
                    }
                },

                // === FUNGSI LIHAT DETAIL ITEM KERANJANG ===
                openItemDetail(item) {
                    Alpine.store('wardrobeModal').openDetail(item);
                },

                formatRupiah(angka) {
                    return 'Rp ' + Number(angka).toLocaleString('id-ID');
                }
            }"
            x-init="
                // Watcher diskon tidak diperlukan lagi
                // Panggil calculateDiscount tidak diperlukan lagi
            "
            >

        <div class="flex-1 overflow-y-auto p-6 pb-32">
            <div class="max-w-4xl mx-auto space-y-4">
                
                <div x-show="cartItems.length > 0" class="flex items-center justify-between mb-4 p-4 bg-white rounded-xl shadow-sm border border-orange-100">
                    <label class="flex items-center gap-3 cursor-pointer text-sm font-bold text-gray-700">
                        <input type="checkbox" @click="toggleSelectAll()" :checked="selectedItems.length > 0 && selectedItems.length === cartItems.length" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300">
                        Pilih Semua <span class="text-xs text-gray-400 font-normal ml-2" x-text="'(' + cartItems.length + ' Barang)'"></span>
                    </label>
                </div>

                <div x-show="cartItems.length === 0" class="flex flex-col items-center justify-center h-full py-20 text-center" x-cloak>
                    <div class="w-40 h-40 bg-orange-100 rounded-full flex items-center justify-center mb-6 shadow-xl border-4 border-white">
                        <span class="text-7xl opacity-50 grayscale transform rotate-12">🛒</span>
                    </div>
                    <h2 class="text-2xl font-display font-extrabold text-gray-800 mb-2">Keranjang Masih Kosong</h2>
                    <p class="text-gray-600 mb-8 max-w-sm mx-auto">
                        Wah, sepertinya kamu belum mengadopsi boneka apapun. Yuk cari teman barumu di Workshop sekarang!
                    </p>
                    <a href="{{ route('workshop') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30 hover:scale-105 transition transform">
                        <span>🚀</span> Mulai Belanja
                    </a>
                </div>

                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-white p-5 rounded-2xl shadow-lg border border-orange-100 flex items-center gap-5 transition hover:shadow-xl hover:border-orange-200 cursor-pointer" @click="openItemDetail(item)">
                        
                        <input type="checkbox" :value="item.id" x-model="selectedItems" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 border-gray-300 shrink-0 cursor-pointer" @click.stop="">
                        
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center text-4xl bg-gray-50 border border-gray-100 shrink-0 shadow-inner" 
                                :style="'background-color:' + item.color">
                            <span x-text="item.image"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="font-display font-bold text-gray-800 text-lg truncate" x-text="item.name + ' (' + item.size + ')'"></h3>
                            <p class="text-xs text-orange-500 uppercase font-bold tracking-wider" x-text="item.type"></p>
                            <div class="flex flex-wrap items-center gap-3 mt-1">
                                <p class="text-2xl font-extrabold text-orange-600 font-display" x-text="formatRupiah(item.price)"></p>
                                <span x-show="item.custom" class="text-[10px] bg-purple-100 text-purple-600 px-2 py-0.5 rounded font-bold">Custom</span>
                            </div>
                        </div>

                        <button type="button" @click.stop="deleteItem(item.id)" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition shrink-0 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <form :id="`delete-form-${item.id}`" action="{{ route('cart.destroy', ['id' => 'TEMP_ID']) }}" method="POST" x-cloak>
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" :value="item.id">
                        </form>
                    </div>
                </template>

            </div>
        </div>

        <div x-show="cartItems.length > 0" class="absolute bottom-0 left-0 right-0 bg-white border-t-2 border-orange-100 p-6 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40" x-transition>
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                
                <div class="flex flex-col gap-2">
                    <span class="font-bold text-gray-700 text-sm">Item Terpilih</span>
                    <span class="text-xl font-extrabold text-gray-900 font-display" x-text="selectedItems.length + ' Item'"></span>
                </div>

                <div class="md:col-span-1 pt-3 md:pt-0">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-600">Subtotal Dipilih</span>
                        <span class="text-3xl font-extrabold text-orange-600 font-display" x-text="formatRupiah(totalSelected)"></span>
                    </div>
                </div>

                <div class="md:col-span-1 flex flex-col items-end gap-3 border-t md:border-t-0 pt-3 md:pt-0">
                    <form action="{{ route('checkout') }}" method="GET" class="w-full">
                        <template x-for="id in selectedItems">
                            <input type="hidden" name="selected_ids[]" :value="id">
                        </template>

                        <button type="submit" 
                                :disabled="selectedItems.length === 0"
                                :class="selectedItems.length === 0 ? 'bg-gray-300 cursor-not-allowed text-gray-600 shadow-none' : 'bg-orange-600 hover:bg-orange-700 shadow-xl shadow-orange-500/30 transform hover:-translate-y-0.5'"
                                class="w-full mt-3 text-white px-10 py-3.5 rounded-xl font-bold transition flex items-center justify-center gap-2 text-lg">
                            Checkout (<span x-text="selectedItems.length"></span> Item)
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
</html>