<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; } 
        [x-cloak] { display: none; }
        .loader { border: 3px solid #f3f3f3; border-top: 3px solid #ea580c; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-gray-100 min-h-screen pb-20">

    <nav class="bg-white border-b border-gray-200 py-4 shadow-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-3xl">🧸</a>
            <div class="h-8 w-px bg-gray-300"></div>
            <h1 class="text-xl font-bold text-gray-700">Kasir Pembayaran</h1>
        </div>
    </nav>

    <!-- STEP INDICATOR -->
    <div class="bg-white border-b border-gray-200 py-4 mb-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex items-center justify-center text-sm font-bold">
                <div class="flex items-center text-green-600">
                    <div class="w-8 h-8 rounded-full border-2 border-green-600 flex items-center justify-center mr-2">✓</div>
                    <span class="hidden sm:inline">Keranjang</span>
                </div>
                <div class="w-12 h-1 bg-green-600 mx-2"></div>
                <div class="flex items-center text-green-600">
                    <div class="w-8 h-8 rounded-full border-2 border-green-600 flex items-center justify-center mr-2">✓</div>
                    <span class="hidden sm:inline">Pengiriman</span>
                </div>
                <div class="w-12 h-1 bg-orange-500 mx-2"></div>
                <div class="flex items-center text-orange-600">
                    <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center mr-2">3</div>
                    <span>Pembayaran</span>
                </div>
                <div class="w-12 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center text-gray-400">
                    <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center mr-2">4</div>
                    <span class="hidden sm:inline">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 md:px-10"
         x-data="{ 
            paymentMethod: 'va_bca', 
            category: 'transfer', 
            step: 1,
            amount: 175000, 
            vaNumber: '', 
            
            // LOGIKA TIMER
            countdown: 86400, // 24 jam dalam detik (24 * 60 * 60)
            timerDisplay: '24:00:00',
            
            item: { name: 'Custom Teddy (Coklat)', outfit: 'Kaos Merah', acc: 'Kacamata' },

            startTimer() {
                let timer = setInterval(() => {
                    if (this.countdown <= 0) {
                        clearInterval(timer);
                        this.timerDisplay = 'Waktu Habis';
                    } else {
                        this.countdown--;
                        const hours = Math.floor(this.countdown / 3600);
                        const minutes = Math.floor((this.countdown % 3600) / 60);
                        const seconds = this.countdown % 60;
                        
                        // Format ke HH:MM:SS
                        this.timerDisplay = 
                            String(hours).padStart(2, '0') + ':' + 
                            String(minutes).padStart(2, '0') + ':' + 
                            String(seconds).padStart(2, '0');
                    }
                }, 1000); // Update tiap 1 detik
            },

            processPayment() {
                this.step = 2; // Loading
                
                setTimeout(() => {
                    // GENERATE NOMOR SESUAI METODE
                    if(this.paymentMethod === 'va_bca') this.vaNumber = '8806 0812 3456 7890';
                    else if(this.paymentMethod === 'va_bri') this.vaNumber = '1299 0812 3456 7890';
                    else if(this.paymentMethod === 'va_mandiri') this.vaNumber = '8900 0812 3456 7890';
                    else if(this.paymentMethod === 'va_bni') this.vaNumber = '9881 0812 3456 7890';
                    else if(this.paymentMethod === 'va_permata') this.vaNumber = '8665 0812 3456 7890';
                    else if(this.paymentMethod === 'alfa') this.vaNumber = 'ALFA-TRX-998821';
                    else if(this.paymentMethod === 'indo') this.vaNumber = 'INDO-TRX-772100';
                    else this.vaNumber = 'QRIS';

                    this.step = 3; 
                    this.startTimer(); // MULAI TIMER SETELAH LOADING SELESAI
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 2000);
            },

            copyToClipboard(text) {
                navigator.clipboard.writeText(text);
                alert('Nomor berhasil disalin!');
            }
         }">

        <!-- STEP 1: PILIH METODE -->
        <div x-show="step === 1" class="flex flex-col md:flex-row gap-6" x-transition>
            
            <!-- KIRI: OPSI PEMBAYARAN -->
            <div class="w-full md:w-3/4 bg-white shadow-sm rounded-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                
                <!-- Sidebar Kategori -->
                <div class="w-full md:w-1/4 bg-gray-50 border-r border-gray-200 p-2 space-y-1">
                    <button @click="category = 'transfer'" :class="category === 'transfer' ? 'bg-white text-orange-600 shadow-sm border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-4 py-3 font-bold text-sm rounded-r-lg transition flex items-center gap-2">
                        <span>🏦</span> Virtual Account
                    </button>
                    <button @click="category = 'ewallet'" :class="category === 'ewallet' ? 'bg-white text-orange-600 shadow-sm border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-4 py-3 font-bold text-sm rounded-r-lg transition flex items-center gap-2">
                        <span>📱</span> E-Wallet / QRIS
                    </button>
                    <button @click="category = 'offline'" :class="category === 'offline' ? 'bg-white text-orange-600 shadow-sm border-l-4 border-orange-500' : 'text-gray-600 hover:bg-gray-100'" class="w-full text-left px-4 py-3 font-bold text-sm rounded-r-lg transition flex items-center gap-2">
                        <span>🏪</span> Minimarket
                    </button>
                </div>

                <!-- Konten Pilihan -->
                <div class="w-full md:w-3/4 p-8 overflow-y-auto max-h-[600px] hide-scroll">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Pilih Metode Pembayaran</h3>

                    <!-- 1. TRANSFER VA -->
                    <div x-show="category === 'transfer'" class="space-y-3" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" :class="paymentMethod === 'va_bca' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_bca" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-blue-800 rounded flex items-center justify-center text-white font-bold text-xs italic">BCA</div>
                            <div><span class="font-bold text-gray-700 block">Bank BCA</span><span class="text-xs text-gray-500">Cek Otomatis</span></div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" :class="paymentMethod === 'va_bri' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_bri" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xs">BRI</div>
                            <div><span class="font-bold text-gray-700 block">Bank BRI</span><span class="text-xs text-gray-500">Cek Otomatis</span></div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" :class="paymentMethod === 'va_mandiri' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_mandiri" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-yellow-400 rounded flex items-center justify-center text-blue-900 font-bold text-xs">Mandiri</div>
                            <div><span class="font-bold text-gray-700 block">Bank Mandiri</span><span class="text-xs text-gray-500">Cek Otomatis</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" :class="paymentMethod === 'va_bni' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_bni" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-orange-600 rounded flex items-center justify-center text-white font-bold text-xs">BNI</div>
                            <div><span class="font-bold text-gray-700 block">Bank BNI</span><span class="text-xs text-gray-500">Cek Otomatis</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition group" :class="paymentMethod === 'va_permata' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="va_permata" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-green-600 rounded flex items-center justify-center text-white font-bold text-xs">Permata</div>
                            <div><span class="font-bold text-gray-700 block">Bank Permata</span><span class="text-xs text-gray-500">Cek Otomatis</span></div>
                        </label>
                    </div>

                    <!-- 2. E-WALLET -->
                    <div x-show="category === 'ewallet'" class="space-y-3" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'shopeepay' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="shopeepay" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-orange-500 rounded flex items-center justify-center text-white font-bold text-[10px]">Shopee</div>
                            <div><span class="font-bold text-gray-700 block">ShopeePay</span><span class="text-xs text-gray-500">Scan QR Code</span></div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'gopay' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="gopay" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-blue-500 rounded flex items-center justify-center text-white font-bold text-[10px]">GoPay</div>
                            <div><span class="font-bold text-gray-700 block">GoPay</span><span class="text-xs text-gray-500">Scan QR Code</span></div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'ovo' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="ovo" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-purple-600 rounded flex items-center justify-center text-white font-bold text-[10px]">OVO</div>
                            <div><span class="font-bold text-gray-700 block">OVO</span><span class="text-xs text-gray-500">Scan QR Code</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'dana' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="dana" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-blue-400 rounded flex items-center justify-center text-white font-bold text-[10px]">DANA</div>
                            <div><span class="font-bold text-gray-700 block">DANA</span><span class="text-xs text-gray-500">Scan QR Code</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'linkaja' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="linkaja" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-red-600 rounded flex items-center justify-center text-white font-bold text-[10px]">LinkAja</div>
                            <div><span class="font-bold text-gray-700 block">LinkAja</span><span class="text-xs text-gray-500">Scan QR Code</span></div>
                        </label>
                    </div>

                    <!-- 3. MINIMARKET -->
                    <div x-show="category === 'offline'" class="space-y-3" x-transition>
                        <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'alfa' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="alfa" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-red-600 rounded flex items-center justify-center text-white font-bold text-[10px]">ALFA</div>
                            <div><span class="font-bold text-gray-700 block">Alfamart</span><span class="text-xs text-gray-500">Bayar di Kasir</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'indo' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="indo" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-[10px] border-b-4 border-red-500">INDO</div>
                            <div><span class="font-bold text-gray-700 block">Indomaret</span><span class="text-xs text-gray-500">Bayar di Kasir</span></div>
                        </label>
                         <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition" :class="paymentMethod === 'alfamidi' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'">
                            <input type="radio" name="pay" value="alfamidi" x-model="paymentMethod" class="text-orange-600 focus:ring-orange-500">
                            <div class="w-14 h-8 bg-red-500 rounded flex items-center justify-center text-white font-bold text-[10px]">MIDI</div>
                            <div><span class="font-bold text-gray-700 block">Alfamidi</span><span class="text-xs text-gray-500">Bayar di Kasir</span></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- KANAN: RINGKASAN TAGIHAN -->
            <div class="w-full md:w-1/4">
                <div class="bg-white shadow-sm rounded-2xl p-6 sticky top-24 border border-gray-100">
                    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Rincian Tagihan</h3>
                    <div class="flex gap-3 mb-4">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-xl">🧸</div>
                        <div class="text-sm">
                            <p class="font-bold text-gray-800" x-text="item.name"></p>
                            <p class="text-xs text-gray-500">+ Outfit & Accs</p>
                        </div>
                    </div>

                    <div class="flex justify-between mb-2 text-sm text-gray-600"><span>Total Pesanan</span><span>Rp 150.000</span></div>
                    <div class="flex justify-between mb-2 text-sm text-gray-600"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
                    <div class="flex justify-between mb-6 pt-2 border-t border-dashed">
                        <span class="font-bold text-gray-800">Total Bayar</span>
                        <span class="font-extrabold text-orange-600 text-lg" x-text="'Rp ' + amount.toLocaleString('id-ID')"></span>
                    </div>
                    <button @click="processPayment()" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-xl shadow-lg transform active:scale-95 transition flex justify-center items-center gap-2">
                        <span>🔒</span> Bayar Sekarang
                    </button>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('checkout') }}" class="text-xs text-gray-400 hover:text-orange-600 font-bold underline">Ubah Pengiriman</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: LOADING OVERLAY -->
        <div x-show="step === 2" class="fixed inset-0 bg-white/90 backdrop-blur-sm flex items-center justify-center z-50" x-cloak>
            <div class="text-center">
                <div class="loader mx-auto mb-4"></div>
                <p class="font-bold text-gray-700 text-lg animate-pulse">Menghubungkan ke Payment Gateway...</p>
                <p class="text-sm text-gray-400">Mohon jangan tutup halaman ini.</p>
            </div>
        </div>

        <!-- STEP 3: INSTRUKSI PEMBAYARAN -->
        <div x-show="step === 3" class="max-w-3xl mx-auto" x-cloak x-transition>
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm">✅</div>
                <h2 class="text-2xl font-extrabold text-gray-800">Menunggu Pembayaran</h2>
                
                <!-- TIMER YANG BERJALAN -->
                <p class="text-gray-500">Selesaikan pembayaran dalam <span class="font-bold text-orange-600 font-mono text-lg" x-text="timerDisplay"></span></p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                
                <!-- A. TAMPILAN KHUSUS VA -->
                <template x-if="paymentMethod.includes('va')">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-100">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Metode Pembayaran</p>
                                <h3 class="font-bold text-lg flex items-center gap-2 uppercase" x-text="paymentMethod.replace('va_', '') + ' Virtual Account'"></h3>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-2xl p-6 mb-8 border border-blue-100">
                            <p class="text-sm text-gray-500 mb-2 font-bold uppercase">Nomor Virtual Account</p>
                            <div class="flex justify-between items-center">
                                <span class="text-3xl font-mono font-extrabold text-blue-800 tracking-widest" x-text="vaNumber"></span>
                                <button @click="copyToClipboard(vaNumber)" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:bg-blue-100 px-3 py-1 rounded transition">SALIN</button>
                            </div>
                            <div class="mt-4 pt-4 border-t border-blue-200 flex justify-between">
                                <span class="font-bold text-gray-700">Total Bayar</span>
                                <span class="font-extrabold text-orange-600 text-xl" x-text="'Rp ' + amount.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-800">Cara Pembayaran:</h4>
                            <ol class="list-decimal pl-5 space-y-2 text-sm text-gray-600">
                                <li>Buka aplikasi M-Banking atau ke ATM.</li>
                                <li>Pilih menu <b>Transfer</b> > <b>Virtual Account</b>.</li>
                                <li>Masukkan nomor VA di atas: <b x-text="vaNumber"></b>.</li>
                                <li>Periksa nama penerima: <b>Build-A-Teddy</b>.</li>
                                <li>Masukkan PIN Anda dan selesai.</li>
                            </ol>
                        </div>
                    </div>
                </template>

                <!-- B. TAMPILAN QRIS/E-WALLET -->
                <template x-if="!paymentMethod.includes('va') && !['alfa', 'indo', 'alfamidi'].includes(paymentMethod)">
                    <div class="p-8 text-center">
                        <h3 class="font-bold text-lg mb-2">Scan QR Code</h3>
                        <p class="text-sm text-gray-500 mb-6">Buka aplikasi E-Wallet pilihanmu untuk bayar.</p>
                        
                        <div class="w-64 h-64 bg-gray-800 mx-auto rounded-xl flex items-center justify-center text-white shadow-lg mb-6 relative group">
                            <div class="absolute inset-2 bg-white p-2 rounded-lg">
                                <div class="w-full h-full bg-[url('https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BuildATeddyPayment')] bg-cover"></div>
                            </div>
                            <div class="absolute bg-white p-1 rounded-full shadow-md">
                                <span class="text-xl">🧸</span>
                            </div>
                        </div>

                        <div class="bg-orange-50 inline-block px-6 py-3 rounded-xl border border-orange-200">
                            <p class="font-bold text-orange-800 text-lg" x-text="'Rp ' + amount.toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                </template>

                <!-- C. TAMPILAN RETAIL -->
                <template x-if="['alfa', 'indo', 'alfamidi'].includes(paymentMethod)">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-lg">Bayar di Kasir</h3>
                            <div class="bg-red-600 text-white font-bold px-3 py-1 text-xs rounded uppercase" x-text="paymentMethod"></div>
                        </div>

                        <div class="bg-gray-100 rounded-2xl p-6 mb-6 text-center border-2 border-dashed border-gray-300">
                            <p class="text-sm text-gray-500 mb-2 uppercase tracking-wide">Kode Pembayaran</p>
                            <h2 class="text-4xl font-mono font-extrabold text-gray-800 tracking-widest" x-text="vaNumber"></h2>
                        </div>

                        <div class="space-y-2 text-sm text-gray-600 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                            <p>1. Datang ke gerai terdekat.</p>
                            <p>2. Bilang ke kasir: <b>"Bayar Merchant Build-A-Teddy"</b>.</p>
                            <p>3. Tunjukkan kode pembayaran di atas.</p>
                            <p>4. Simpan struk sebagai bukti pembayaran.</p>
                        </div>
                    </div>
                </template>

                <!-- Footer Kartu -->
                <div class="bg-gray-50 p-6 border-t border-gray-100 flex justify-between items-center">
                    <div class="text-xs text-gray-400">
                        <p>Order ID: #TRX-882910</p>
                        <p>Tanggal: {{ date('d M Y') }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button class="text-gray-500 font-bold hover:text-gray-700 text-sm px-4 py-2">Bantuan</button>
                        <a href="{{ route('history') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl font-bold shadow hover:bg-gray-800 transition">
                            Cek Status Pesanan
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-orange-600 font-bold text-sm">Kembali ke Beranda</a>
            </div>

        </div>

    </div>
</body>
</html>