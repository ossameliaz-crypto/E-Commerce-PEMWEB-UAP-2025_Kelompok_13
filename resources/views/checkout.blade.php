<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        .font-display { font-family: 'Fredoka', sans-serif; }
        .sticky-summary { top: 24px; }
        .input-style {
            border: 2px solid #E5E7EB;
            transition: all 0.2s;
        }
        .input-style:focus {
            border-color: #F97316; /* Orange-500 */
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }
        .courier-card {
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: relative;
            padding-left: 50px; /* Ruang untuk ikon boneka */
        }
        .courier-card:hover {
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.1);
        }
        .bear-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%) rotate(-10deg);
            font-size: 20px;
            color: #ea580c; /* Orange-600 */
        }
        .courier-label {
            display: block;
            margin-left: 10px; /* Jarak dari radio button */
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: { 50: '#fff7ed', 100: '#ffedd5', 500: '#f97316', 600: '#ea580c', 700: '#c2410c' },
                        red: { 500: '#ef4444' }
                    }
                }
            }
        }

        window.formatRupiah = (angka) => {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        };
    </script>
</head>
<body class="bg-orange-50/50 min-h-screen">

    @php
        // Menggunakan nilai $cartTotal yang dihitung di TransactionController::checkout()
        $subtotalProducts = $cartTotal ?? 150000;
        
        // Asumsi $carts sudah di-pass untuk Ringkasan Item
    @endphp

    <nav class="bg-white border-b border-orange-100 py-4 shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 flex items-center gap-4">
            <a href="{{ route('wardrobe') }}" class="text-2xl text-gray-700 hover:text-orange-600 transition">←</a>
            <div class="h-8 w-px bg-gray-300"></div>
            <h1 class="text-2xl font-display font-extrabold text-gray-800">Pengiriman 📦</h1>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-10" 
          x-data="{ 
            subtotal: {{ $subtotalProducts }}, 
            discount: 0,
            
            shippingCost: 0,
            selectedCourier: null,
            city: '', 

            get isMalang() { return this.city.toLowerCase().includes('malang'); },
            
            get rates() {
                // Tambahan Kurir yang diminta
                if (this.isMalang) return { 'jne': 8000, 'jnt': 10000, 'gosend': 15000, 'grabexpress': 16000, 'sicepat': 9000, 'anteraja': 11000 };
                else return { 'jne': 22000, 'jnt': 28000, 'gosend': null, 'grabexpress': null, 'sicepat': 25000, 'anteraja': 30000 };
            },
            
            get total() { return this.subtotal + this.shippingCost; },

            selectCourier(courier) {
                const isInstant = (courier === 'gosend' || courier === 'grabexpress');
                
                if (isInstant && !this.isMalang) {
                    this.selectedCourier = null;
                    this.shippingCost = 0;
                    return;
                }
                this.selectedCourier = courier;
                this.shippingCost = this.rates[courier] || 0;
            },

            resetShipping() {
                this.selectedCourier = null;
                this.shippingCost = 0;
            },

            formatRupiah(angka) {
                return 'Rp ' + Number(angka).toLocaleString('id-ID');
            }
          }">

        <form action="{{ route('payment') }}" method="GET" class="flex flex-col md:flex-row gap-8">
            
            <div class="md:w-2/3 space-y-6">
                
                <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-orange-100">
                    <h3 class="font-display font-bold text-lg mb-6 flex items-center gap-2 text-gray-800">
                        <span class="bg-orange-100 p-2 rounded-xl text-xl">🏠</span> Informasi Penerima
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Nama Penerima" class="w-full bg-gray-50 input-style rounded-xl px-4 py-3 focus:ring-orange-500 outline-none transition" required>
                        <input type="text" name="phone" placeholder="Nomor HP" class="w-full bg-gray-50 input-style rounded-xl px-4 py-3 focus:ring-orange-500 outline-none transition" required>
                        <textarea name="address" placeholder="Alamat Lengkap (Jalan, No. Rumah, RT/RW)" rows="3" class="md:col-span-2 w-full bg-gray-50 input-style rounded-xl px-4 py-3 focus:ring-orange-500 outline-none transition" required></textarea>
                        
                        <input type="text" name="city" x-model="city" @input="resetShipping()" placeholder="Kota / Kecamatan (Cth: Malang)" class="w-full input-style border-orange-200 rounded-xl px-4 py-3 focus:ring-orange-500 outline-none font-bold text-gray-700" required>
                        <input type="text" name="postal_code" placeholder="Kode Pos" class="w-full bg-gray-50 input-style rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none" required>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-orange-100 transition-all duration-300" 
                        :class="city.length < 3 ? 'opacity-50 pointer-events-none grayscale' : 'opacity-100'">
                    
                    <h3 class="font-display font-bold text-lg mb-6 flex items-center gap-2 text-gray-800">
                        <span class="bg-orange-100 p-2 rounded-xl text-xl">🚚</span> Metode Pengiriman
                    </h3>
                    
                    <p x-show="city.length < 3" class="text-sm text-red-500 mb-3 font-bold">*Isi Kota terlebih dahulu untuk melihat ongkir</p>

                    <div class="space-y-3">
                        
                        <template x-for="(rate, courier) in rates">
                            <label x-show="rate !== null" :key="courier" class="flex items-center justify-between p-4 courier-card rounded-xl cursor-pointer" :class="selectedCourier === courier ? 'border-2 border-orange-600 bg-orange-50' : 'border border-gray-200'">
                                <span class="bear-icon">🧸</span>
                                
                                <div class="flex items-center gap-3 w-full">
                                    <input type="radio" name="courier" :value="courier" @click="selectCourier(courier)" class="text-orange-600 focus:ring-orange-500 w-5 h-5 ml-2" required>
                                    <div class="courier-label ml-0">
                                        <span class="font-bold block text-gray-800" 
                                            x-text="courier.toUpperCase().replace('_', ' ') + ((courier === 'gosend' || courier === 'grabexpress') ? ' Instant' : ' Reguler')"></span>
                                        <span class="text-xs text-gray-500" 
                                            x-text="isMalang ? ((courier === 'gosend' || courier === 'grabexpress') ? 'Tiba Hari Ini' : 'Estimasi 1-2 Hari') : 'Estimasi 2-5 Hari'"></span>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-700 mr-2" x-text="formatRupiah(rate)"></span>
                            </label>
                        </template>

                    </div>
                </div>
            </div>

            <div class="md:w-1/3">
                <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-orange-100 sticky-summary sticky">
                    <h3 class="font-display font-bold text-xl mb-4 flex items-center gap-2">Ringkasan Pembayaran 💰</h3>
                    
                    <div class="space-y-3 mb-6 border-b border-gray-100 pb-6 max-h-60 overflow-y-auto">
                        @forelse($carts as $item)
                            <div class="flex justify-between items-start text-sm">
                                <span class="text-gray-600 truncate mr-2">🐻 {{ ucfirst($item->base_model ?? 'Custom') }} Bear ({{ $item->size }})</span>
                                <span class="font-bold text-gray-800 shrink-0">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 text-center">Tidak ada item terpilih.</p>
                        @endforelse
                    </div>

                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span class="flex items-center gap-2">🧸 Subtotal Produk</span>
                            <span class="font-bold" x-text="formatRupiah(subtotal)"></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="flex items-center gap-2">📦 Biaya Pengiriman</span>
                            <span class="font-bold" :class="selectedCourier ? 'text-gray-800' : 'text-gray-300'" 
                                    x-text="selectedCourier ? formatRupiah(shippingCost) : 'Pilih Kurir'"></span>
                        </div>
                    </div>

                    <div class="flex justify-between font-extrabold text-xl text-gray-900 pt-4 border-t border-dashed border-gray-300">
                        <span>Total Tagihan ✨</span>
                        <span class="text-orange-600 text-2xl font-display" x-text="formatRupiah(total)"></span>
                    </div>

                    <button type="submit" 
                            :disabled="!selectedCourier"
                            :class="!selectedCourier ? 'bg-gray-300 cursor-not-allowed shadow-none' : 'bg-orange-600 hover:bg-orange-700 shadow-xl shadow-orange-500/30 transform hover:-translate-y-0.5'"
                            class="w-full text-white font-bold py-4 mt-6 rounded-xl transition flex justify-center items-center gap-2">
                        <span x-text="!selectedCourier ? 'Pilih Kurir Dulu' : 'Lanjut Pembayaran'"></span>
                        <span x-show="selectedCourier">➜</span>
                    </button>
                    
                    <p x-show="!selectedCourier" class="text-xs text-center text-red-400 mt-2 font-bold animate-pulse">
                        *Mohon lengkapi pengiriman
                    </p>
                </div>
            </div>
        </form>
    </div>

</body>
</html>