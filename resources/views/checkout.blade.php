<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-orange-50/50 min-h-screen">

    <!-- Navbar Simpel -->
    <nav class="bg-white border-b border-gray-200 py-4 shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <div class="h-8 w-px bg-gray-300"></div>
            <h1 class="text-xl font-bold text-gray-700">Pengiriman</h1>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-10" 
         x-data="{ 
            subtotal: 150000, 
            shippingCost: 0,
            selectedCourier: null,
            city: '', // Variable untuk menangkap input kota

            // Logika Cek Apakah Malang
            get isMalang() {
                return this.city.toLowerCase().includes('malang');
            },

            // Daftar Harga Dinamis
            get rates() {
                if (this.isMalang) {
                    // Harga Lokal (Murah)
                    return { 'jne': 8000, 'jnt': 10000, 'gosend': 15000 };
                } else {
                    // Harga Luar Kota (Mahal & No GoSend)
                    return { 'jne': 22000, 'jnt': 28000, 'gosend': null };
                }
            },
            
            get total() {
                return this.subtotal + this.shippingCost;
            },

            // Update Ongkir saat pilih kurir
            selectCourier(courier) {
                if (courier === 'gosend' && !this.isMalang) {
                    alert('Maaf, GoSend hanya tersedia untuk area Malang!');
                    return;
                }
                this.selectedCourier = courier;
                this.shippingCost = this.rates[courier];
            },

            // Reset kalau ganti kota
            resetShipping() {
                this.selectedCourier = null;
                this.shippingCost = 0;
            },

            formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }
         }">

        <form action="{{ route('payment') }}" method="GET" class="flex flex-col md:flex-row gap-8">
            
            <!-- KIRI: FORM ALAMAT & KURIR -->
            <div class="md:w-2/3 space-y-6">
                
                <!-- 1. Alamat -->
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-orange-100">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="bg-orange-100 p-1.5 rounded-lg">📍</span> Alamat Penerima
                    </h3>
                    
                    <!-- Alert Simulasi -->
                    <div class="mb-4 bg-blue-50 text-blue-700 text-xs p-3 rounded-lg border border-blue-200">
                        💡 <b>Tips Demo:</b> Ketik <b>"Malang"</b> di kolom Kota untuk ongkir murah & GoSend. Ketik kota lain untuk ongkir reguler.
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Penerima" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                        <input type="text" placeholder="Nomor HP" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                        <textarea placeholder="Alamat Lengkap (Jalan, No. Rumah, RT/RW)" rows="3" class="md:col-span-2 w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none transition" required></textarea>
                        
                        <!-- INPUT KOTA (Logic trigger) -->
                        <input type="text" x-model="city" @input="resetShipping()" placeholder="Kota / Kecamatan (Cth: Malang)" 
                               class="w-full bg-white border-2 border-orange-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none transition font-bold text-gray-700" required>
                        
                        <input type="text" placeholder="Kode Pos" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                    </div>
                </div>

                <!-- 2. Pilih Kurir (Logic Disini) -->
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-orange-100 transition-all duration-300"
                     :class="city.length < 3 ? 'opacity-50 pointer-events-none grayscale' : 'opacity-100'">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="bg-blue-100 p-1.5 rounded-lg">🚚</span> Pilih Pengiriman
                    </h3>
                    
                    <p x-show="city.length < 3" class="text-sm text-red-500 mb-3 font-bold">*Isi Kota terlebih dahulu untuk melihat ongkir</p>

                    <div class="space-y-3">
                        <!-- Opsi JNE -->
                        <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" 
                               :class="selectedCourier === 'jne' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="courier" value="jne" 
                                       @click="selectCourier('jne')"
                                       class="text-orange-600 focus:ring-orange-500 w-5 h-5">
                                <div>
                                    <span class="font-bold block text-gray-800">JNE Reguler</span>
                                    <span class="text-xs text-gray-500" x-text="isMalang ? 'Estimasi 1 Hari' : 'Estimasi 2-4 Hari'"></span>
                                </div>
                            </div>
                            <span class="font-bold text-gray-700 group-hover:text-orange-600" x-text="formatRupiah(rates.jne)"></span>
                        </label>

                        <!-- Opsi J&T -->
                        <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group"
                               :class="selectedCourier === 'jnt' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="courier" value="jnt" 
                                       @click="selectCourier('jnt')"
                                       class="text-orange-600 focus:ring-orange-500 w-5 h-5">
                                <div>
                                    <span class="font-bold block text-gray-800">J&T Express</span>
                                    <span class="text-xs text-gray-500" x-text="isMalang ? 'Estimasi 1 Hari' : 'Estimasi 2-3 Hari'"></span>
                                </div>
                            </div>
                            <span class="font-bold text-gray-700 group-hover:text-orange-600" x-text="formatRupiah(rates.jnt)"></span>
                        </label>

                        <!-- Opsi Instant (Hanya Malang) -->
                        <label class="flex items-center justify-between p-4 border rounded-xl transition group"
                               :class="!isMalang ? 'bg-gray-100 cursor-not-allowed opacity-60' : (selectedCourier === 'gosend' ? 'border-orange-500 bg-orange-50 cursor-pointer' : 'border-gray-200 cursor-pointer hover:border-orange-500')">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="courier" value="gosend" 
                                       :disabled="!isMalang"
                                       @click="selectCourier('gosend')"
                                       class="text-orange-600 focus:ring-orange-500 w-5 h-5">
                                <div>
                                    <span class="font-bold block text-gray-800">GoSend Instant</span>
                                    <span class="text-xs" :class="isMalang ? 'text-gray-500' : 'text-red-500 font-bold'" x-text="isMalang ? 'Tiba Hari Ini' : 'Tidak Tersedia (Luar Kota)'"></span>
                                </div>
                            </div>
                            <span class="font-bold text-gray-700 group-hover:text-orange-600" x-show="isMalang" x-text="formatRupiah(rates.gosend)"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- KANAN: RINGKASAN BELANJA (STICKY) -->
            <div class="md:w-1/3">
                <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-orange-100 sticky top-24">
                    <h3 class="font-bold text-lg mb-6">Ringkasan Pesanan</h3>
                    
                    <!-- Item List (Preview Barang) -->
                    <div class="space-y-4 mb-6 border-b border-gray-100 pb-6 max-h-60 overflow-y-auto">
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-orange-50 rounded-xl flex items-center justify-center text-2xl border border-orange-100">🧸</div>
                            <div>
                                <p class="font-bold text-sm text-gray-800">Custom Teddy</p>
                                <p class="text-xs text-gray-500">Base: Coklat</p>
                                <p class="text-orange-600 font-bold text-sm mt-1" x-text="formatRupiah(subtotal)"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal Produk</span>
                            <span class="font-bold" x-text="formatRupiah(subtotal)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <!-- Tampilkan 0 atau - jika belum pilih -->
                            <span class="font-bold" :class="selectedCourier ? 'text-gray-800' : 'text-gray-300'" 
                                  x-text="selectedCourier ? formatRupiah(shippingCost) : '-'"></span>
                        </div>
                        <div class="flex justify-between font-extrabold text-lg text-gray-900 pt-4 border-t border-dashed border-gray-300">
                            <span>Total Tagihan</span>
                            <span class="text-orange-600" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>

                    <!-- Tombol Lanjut (Disabled jika belum pilih kurir) -->
                    <button type="submit" 
                            :disabled="!selectedCourier"
                            :class="!selectedCourier ? 'bg-gray-300 cursor-not-allowed' : 'bg-orange-600 hover:bg-orange-700 shadow-lg transform hover:-translate-y-1'"
                            class="w-full text-white font-bold py-4 rounded-xl transition flex justify-center items-center gap-2">
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