<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; } [x-cloak] { display: none; }</style>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white border-b border-gray-200 py-4 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <div class="h-8 w-px bg-gray-300"></div>
            <h1 class="text-xl font-bold text-gray-700">Pembayaran</h1>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-10"
         x-data="{ 
            paymentMethod: 'va_bca', 
            category: 'transfer', 
            step: 1,
            amount: 170000,
            
            pay() {
                this.step = 2;
                setTimeout(() => { this.step = 3; }, 2000);
            }
         }">

        <!-- STEP 1: PILIH METODE -->
        <div x-show="step === 1" class="flex flex-col md:flex-row gap-6">
            
            <!-- KIRI: KATEGORI PEMBAYARAN -->
            <div class="w-full md:w-3/4 bg-white shadow-sm rounded-lg overflow-hidden flex flex-col md:flex-row min-h-[500px]">
                
                <!-- Sidebar -->
                <div class="w-full md:w-1/4 bg-gray-50 border-r border-gray-200">
                    <button @click="category = 'ewallet'" :class="category === 'ewallet' ? 'bg-white text-orange-600 border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-6 py-4 font-bold text-sm transition">ShopeePay / E-Wallet</button>
                    <button @click="category = 'transfer'" :class="category === 'transfer' ? 'bg-white text-orange-600 border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-6 py-4 font-bold text-sm transition">Transfer Bank (VA)</button>
                    <button @click="category = 'offline'" :class="category === 'offline' ? 'bg-white text-orange-600 border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-6 py-4 font-bold text-sm transition">COD / Alfamart</button>
                </div>

                <!-- Konten Pilihan -->
                <div class="w-full md:w-3/4 p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Pilih Metode Pembayaran</h3>

                    <!-- E-Wallet -->
                    <div x-show="category === 'ewallet'" class="space-y-4" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'shopeepay' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="shopeepay" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-10 h-10 bg-orange-500 rounded flex items-center justify-center text-white font-bold text-xs">S-Pay</div>
                            <span class="font-bold text-gray-700">ShopeePay</span>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'gopay' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="gopay" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-10 h-10 bg-blue-500 rounded flex items-center justify-center text-white font-bold text-xs">Gopay</div>
                            <span class="font-bold text-gray-700">GoPay</span>
                        </label>
                    </div>

                    <!-- Transfer VA -->
                    <div x-show="category === 'transfer'" class="space-y-4" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'va_bca' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_bca" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-10 h-10 bg-blue-700 rounded flex items-center justify-center text-white font-bold text-xs">BCA</div>
                            <div><span class="font-bold text-gray-700 block">Bank BCA</span><span class="text-xs text-gray-500">Dicek Otomatis</span></div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'va_bri' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_bri" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-10 h-10 bg-blue-500 rounded flex items-center justify-center text-white font-bold text-xs">BRI</div>
                            <div><span class="font-bold text-gray-700 block">Bank BRI</span><span class="text-xs text-gray-500">Dicek Otomatis</span></div>
                        </label>
                    </div>

                    <!-- Offline -->
                    <div x-show="category === 'offline'" class="space-y-4" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'cod' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="cod" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <span class="text-2xl">📦</span>
                            <span class="font-bold text-gray-700">COD (Bayar di Tempat)</span>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'alfa' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                            <input type="radio" name="pay" value="alfa" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center text-white font-bold text-xs">Alfa</div>
                            <span class="font-bold text-gray-700">Alfamart / Indomaret</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- KANAN: RINGKASAN -->
            <div class="w-full md:w-1/4">
                <div class="bg-white shadow-sm rounded-lg p-6 sticky top-6">
                    <h3 class="font-bold text-gray-700 mb-4">Ringkasan Pesanan</h3>
                    <div class="flex justify-between mb-2 text-sm text-gray-600"><span>Total Belanja</span><span>Rp 150.000</span></div>
                    <div class="flex justify-between mb-2 text-sm text-gray-600"><span>Ongkos Kirim</span><span>Rp 20.000</span></div>
                    <hr class="my-4 border-dashed">
                    <div class="flex justify-between mb-6">
                        <span class="font-bold text-gray-800">Total Tagihan</span>
                        <span class="font-extrabold text-orange-600 text-xl" x-text="'Rp ' + amount.toLocaleString('id-ID')"></span>
                    </div>
                    <button @click="pay()" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg shadow-lg transform active:scale-95 transition">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </div>

        <!-- LOADING & SUKSES -->
        <div x-show="step === 2" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-cloak>
            <div class="bg-white p-8 rounded-2xl flex flex-col items-center">
                <div class="w-12 h-12 border-4 border-orange-200 border-t-orange-600 rounded-full animate-spin mb-4"></div>
                <p class="font-bold text-gray-700">Memproses Pembayaran...</p>
            </div>
        </div>

        <div x-show="step === 3" class="max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-10" x-cloak>
            <div class="bg-green-500 p-6 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-4xl shadow-md">✅</div>
                <h2 class="text-white font-bold text-2xl">Pesanan Dibuat!</h2>
                <p class="text-green-100">Silakan lakukan pembayaran.</p>
            </div>
            <div class="p-8 text-center">
                <p class="text-gray-500 text-sm font-bold uppercase mb-2">Kode Pembayaran</p>
                <div class="bg-gray-100 px-6 py-4 rounded-xl text-3xl font-mono font-bold text-gray-800 tracking-widest mb-6 border border-gray-300">
                    8800 1234 5678
                </div>
                <a href="{{ url('/') }}" class="block w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition">Kembali ke Toko</a>
            </div>
        </div>

    </div>
</body>
</html>