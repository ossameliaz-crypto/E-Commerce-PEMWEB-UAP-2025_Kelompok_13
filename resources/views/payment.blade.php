<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; } 
        [x-cloak] { display: none !important; }
        
        .hide-scroll::-webkit-scrollbar { width: 4px; }
        .hide-scroll::-webkit-scrollbar-thumb { background: #fed7aa; border-radius: 4px; }
        .hide-scroll::-webkit-scrollbar-track { background: transparent; }

        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #ea580c; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        /* Bank Colors */
        .bg-bca { background-color: #004D99; }
        .bg-bri { background-color: #00529C; }
        .bg-mandiri { background-color: #FFB700; color: #003D79; }
        .bg-bni { background-color: #F15A23; }
        .bg-permata { background-color: #00A651; }
        .bg-cimb { background-color: #DA291C; }
        .bg-bsi { background-color: #00A39D; }
        .bg-danamon { background-color: #F58220; }
    </style>
    <script>
        window.formatRupiah = (angka) => {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        };
    </script>
</head>
<body class="bg-[#FFFBF5] min-h-screen pb-20 text-gray-700">

    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 py-4 shadow-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 flex items-center gap-3">
            <span class="text-3xl bg-orange-50 p-1 rounded-lg border border-orange-100">🧸</span>
            <div class="h-8 w-px bg-gray-300"></div>
            <div>
                <h1 class="text-lg font-black text-gray-800 tracking-tight">Kasir Pembayaran</h1>
                <p class="text-xs text-gray-400 font-bold">Secure Checkout</p>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 md:px-8 mt-8"
         x-data="{ 
             step: 1, 
             paymentMethod: 'va_bca', 
             category: 'transfer', 
             
             // --- DATA MANIPULASI (Fixed Data) ---
             totalDue: 198000, 
             
             vaNumber: '', 
             countdown: 86400, 
             timerDisplay: '24:00:00',
             
             startTimer() {
                 let timer = setInterval(() => {
                     if (this.countdown <= 0) {
                         clearInterval(timer);
                         this.timerDisplay = 'Waktu Habis';
                     } else {
                         this.countdown--;
                         const h = Math.floor(this.countdown / 3600);
                         const m = Math.floor((this.countdown % 3600) / 60);
                         const s = this.countdown % 60;
                         this.timerDisplay = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
                     }
                 }, 1000); 
             },

             processPayment() {
                 this.step = 2; // Loading
                 window.scrollTo({ top: 0, behavior: 'smooth' });
                 
                 setTimeout(() => {
                     // Generate Data Dummy
                     if(this.paymentMethod.includes('bca')) this.vaNumber = '8806 0812 3456 7890';
                     else if(this.paymentMethod.includes('bri')) this.vaNumber = '1299 0812 3456 7890';
                     else if(this.paymentMethod.includes('mandiri')) this.vaNumber = '8900 0812 3456 7890';
                     else if(this.paymentMethod.includes('bni')) this.vaNumber = '9881 0812 3456 7890';
                     else if(this.paymentMethod.includes('permata')) this.vaNumber = '8665 0812 3456 7890';
                     else if(this.paymentMethod.includes('cimb')) this.vaNumber = '7788 0812 3456 7890';
                     else if(this.paymentMethod.includes('bsi')) this.vaNumber = '5566 0812 3456 7890';
                     else if(this.paymentMethod.includes('danamon')) this.vaNumber = '3344 0812 3456 7890';
                     else if(this.paymentMethod === 'cod') this.vaNumber = 'COD';
                     else if(['alfa', 'indo', 'alfamidi', 'lawson', 'dandan'].includes(this.paymentMethod)) this.vaNumber = 'PAY-' + Math.floor(Math.random() * 999999);
                     else this.vaNumber = 'QRIS'; 

                     this.step = 3; 
                     if(this.paymentMethod !== 'cod') this.startTimer(); 
                 }, 2000); 
             },

             copyToClipboard(text) {
                 navigator.clipboard.writeText(text);
                 alert('Nomor disalin!');
             }
         }">

        <div x-show="step === 1" x-transition.opacity>
            
            <div class="bg-white shadow-xl shadow-orange-100/50 border border-white rounded-[2rem] overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                
                <div class="w-full md:w-1/4 bg-gray-50/80 p-4 space-y-2 border-r border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-4 mt-2">Kategori</p>
                    
                    <button @click="category = 'transfer'" 
                            :class="category === 'transfer' ? 'bg-white text-orange-600 shadow-md ring-1 ring-orange-100' : 'text-gray-500 hover:bg-white hover:text-gray-700'" 
                            class="w-full text-left px-4 py-3 font-bold text-sm rounded-xl transition-all flex items-center gap-3">
                        <span class="text-lg">🏦</span> Transfer Bank
                    </button>
                    
                    <button @click="category = 'ewallet'" 
                            :class="category === 'ewallet' ? 'bg-white text-orange-600 shadow-md ring-1 ring-orange-100' : 'text-gray-500 hover:bg-white hover:text-gray-700'" 
                            class="w-full text-left px-4 py-3 font-bold text-sm rounded-xl transition-all flex items-center gap-3">
                        <span class="text-lg">📱</span> E-Wallet
                    </button>
                    
                    <button @click="category = 'offline'" 
                            :class="category === 'offline' ? 'bg-white text-orange-600 shadow-md ring-1 ring-orange-100' : 'text-gray-500 hover:bg-white hover:text-gray-700'" 
                            class="w-full text-left px-4 py-3 font-bold text-sm rounded-xl transition-all flex items-center gap-3">
                        <span class="text-lg">🏪</span> Minimarket
                    </button>

                    <button @click="category = 'cod'" 
                            :class="category === 'cod' ? 'bg-white text-orange-600 shadow-md ring-1 ring-orange-100' : 'text-gray-500 hover:bg-white hover:text-gray-700'" 
                            class="w-full text-left px-4 py-3 font-bold text-sm rounded-xl transition-all flex items-center gap-3">
                        <span class="text-lg">📦</span> COD
                    </button>
                </div>

                <div class="w-full md:w-3/4 flex flex-col">
                    <div class="p-8 flex-1 overflow-y-auto max-h-[600px] hide-scroll">
                        <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-2">
                            <span>Pilih Metode Pembayaran</span>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">Otomatis</span>
                        </h3>

                        <div x-show="category === 'transfer'" class="grid grid-cols-1 md:grid-cols-2 gap-4" x-transition>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition" :class="paymentMethod === 'va_bca' ? 'border-blue-600 bg-blue-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_bca" x-model="paymentMethod" class="w-4 h-4 accent-blue-600">
                                <div class="w-12 h-8 bg-bca rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">BCA</div>
                                <span class="font-bold text-sm text-gray-700">BCA Virtual Account</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition" :class="paymentMethod === 'va_bri' ? 'border-blue-600 bg-blue-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_bri" x-model="paymentMethod" class="w-4 h-4 accent-blue-600">
                                <div class="w-12 h-8 bg-bri rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">BRI</div>
                                <span class="font-bold text-sm text-gray-700">BRI Virtual Account</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-yellow-500 hover:bg-yellow-50 transition" :class="paymentMethod === 'va_mandiri' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_mandiri" x-model="paymentMethod" class="w-4 h-4 accent-yellow-600">
                                <div class="w-12 h-8 bg-mandiri rounded text-blue-900 flex items-center justify-center text-xs font-bold shadow-sm">MDR</div>
                                <span class="font-bold text-sm text-gray-700">Mandiri VA</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition" :class="paymentMethod === 'va_bni' ? 'border-orange-500 bg-orange-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_bni" x-model="paymentMethod" class="w-4 h-4 accent-orange-600">
                                <div class="w-12 h-8 bg-bni rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">BNI</div>
                                <span class="font-bold text-sm text-gray-700">BNI Virtual Account</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-green-500 hover:bg-green-50 transition" :class="paymentMethod === 'va_permata' ? 'border-green-500 bg-green-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_permata" x-model="paymentMethod" class="w-4 h-4 accent-green-600">
                                <div class="w-12 h-8 bg-permata rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">PER</div>
                                <span class="font-bold text-sm text-gray-700">Permata VA</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-red-600 hover:bg-red-50 transition" :class="paymentMethod === 'va_cimb' ? 'border-red-600 bg-red-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_cimb" x-model="paymentMethod" class="w-4 h-4 accent-red-600">
                                <div class="w-12 h-8 bg-cimb rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">CIMB</div>
                                <span class="font-bold text-sm text-gray-700">CIMB Niaga VA</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition" :class="paymentMethod === 'va_bsi' ? 'border-teal-500 bg-teal-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_bsi" x-model="paymentMethod" class="w-4 h-4 accent-teal-600">
                                <div class="w-12 h-8 bg-bsi rounded text-white flex items-center justify-center text-xs font-bold shadow-sm">BSI</div>
                                <span class="font-bold text-sm text-gray-700">BSI Syariah</span>
                            </label>
                            <label class="group flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition" :class="paymentMethod === 'va_danamon' ? 'border-orange-400 bg-orange-50' : 'border-gray-100'">
                                <input type="radio" name="pay" value="va_danamon" x-model="paymentMethod" class="w-4 h-4 accent-orange-400">
                                <div class="w-12 h-8 bg-danamon rounded text-white flex items-center justify-center text-[10px] font-bold shadow-sm">DNM</div>
                                <span class="font-bold text-sm text-gray-700">Bank Danamon</span>
                            </label>
                        </div>

                        <div x-show="category === 'ewallet'" class="space-y-4" x-transition>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition relative" :class="paymentMethod === 'shopeepay' ? 'border-orange-500 bg-orange-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="shopeepay" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">SP</div>
                                        <span class="font-bold text-xs text-gray-700">ShopeePay</span>
                                    </div>
                                    <div x-show="paymentMethod === 'shopeepay'" class="absolute top-2 right-2 text-orange-600 font-bold">✓</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-green-500 hover:bg-green-50 transition relative" :class="paymentMethod === 'gopay' ? 'border-green-500 bg-green-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="gopay" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">GO</div>
                                        <span class="font-bold text-xs text-gray-700">GoPay</span>
                                    </div>
                                    <div x-show="paymentMethod === 'gopay'" class="absolute top-2 right-2 text-green-600 font-bold">✓</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition relative" :class="paymentMethod === 'ovo' ? 'border-purple-500 bg-purple-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="ovo" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">OVO</div>
                                        <span class="font-bold text-xs text-gray-700">OVO</span>
                                    </div>
                                    <div x-show="paymentMethod === 'ovo'" class="absolute top-2 right-2 text-purple-600 font-bold">✓</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition relative" :class="paymentMethod === 'dana' ? 'border-blue-400 bg-blue-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="dana" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-blue-400 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">DN</div>
                                        <span class="font-bold text-xs text-gray-700">DANA</span>
                                    </div>
                                    <div x-show="paymentMethod === 'dana'" class="absolute top-2 right-2 text-blue-500 font-bold">✓</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-red-500 hover:bg-red-50 transition relative" :class="paymentMethod === 'linkaja' ? 'border-red-500 bg-red-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="linkaja" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">LA</div>
                                        <span class="font-bold text-xs text-gray-700">LinkAja</span>
                                    </div>
                                    <div x-show="paymentMethod === 'linkaja'" class="absolute top-2 right-2 text-red-600 font-bold">✓</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition relative" :class="paymentMethod === 'jenius' ? 'border-orange-400 bg-orange-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="jenius" x-model="paymentMethod" class="hidden">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 bg-orange-400 rounded-lg flex items-center justify-center text-white text-[10px] font-bold">JP</div>
                                        <span class="font-bold text-xs text-gray-700">Jenius Pay</span>
                                    </div>
                                    <div x-show="paymentMethod === 'jenius'" class="absolute top-2 right-2 text-orange-600 font-bold">✓</div>
                                </label>
                            </div>
                        </div>

                        <div x-show="category === 'offline'" class="space-y-4" x-transition>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-red-600 hover:bg-red-50 transition" :class="paymentMethod === 'alfa' ? 'border-red-600 bg-red-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="alfa" x-model="paymentMethod" class="hidden">
                                    <div class="font-black text-red-600 text-sm">ALFAMART</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition" :class="paymentMethod === 'indo' ? 'border-blue-600 bg-blue-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="indo" x-model="paymentMethod" class="hidden">
                                    <div class="font-black text-blue-600 text-sm">INDOMARET</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-red-400 hover:bg-red-50 transition" :class="paymentMethod === 'alfamidi' ? 'border-red-400 bg-red-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="alfamidi" x-model="paymentMethod" class="hidden">
                                    <div class="font-black text-red-500 text-sm">ALFAMIDI</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition" :class="paymentMethod === 'lawson' ? 'border-blue-400 bg-blue-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="lawson" x-model="paymentMethod" class="hidden">
                                    <div class="font-black text-blue-400 text-sm">LAWSON</div>
                                </label>
                                <label class="border-2 rounded-2xl p-4 cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition" :class="paymentMethod === 'dandan' ? 'border-orange-400 bg-orange-50' : 'border-gray-100'">
                                    <input type="radio" name="pay" value="dandan" x-model="paymentMethod" class="hidden">
                                    <div class="font-black text-orange-500 text-sm">DAN+DAN</div>
                                </label>
                            </div>
                        </div>

                        <div x-show="category === 'cod'" x-transition class="h-full flex items-center justify-center p-8 text-center">
                            <div>
                                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">📦</div>
                                <h3 class="font-bold text-gray-800 text-lg">Bayar Di Tempat</h3>
                                <p class="text-sm text-gray-500 mb-6">Bayar tunai kepada kurir saat paket sampai.</p>
                                <label class="inline-block bg-white border-2 border-orange-500 text-orange-600 px-8 py-3 rounded-xl font-bold cursor-pointer hover:bg-orange-50 transition shadow-sm">
                                    <input type="radio" name="pay" value="cod" x-model="paymentMethod" class="hidden">
                                    <span>Pilih COD</span>
                                </label>
                                <div x-show="paymentMethod === 'cod'" class="mt-4 text-green-600 text-sm font-bold bg-green-50 px-4 py-2 rounded-full inline-block">✓ Siap Dikirim</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                        <button @click="processPayment()" class="bg-gray-900 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:bg-gray-800 hover:-translate-y-0.5 transition flex items-center gap-2">
                            <span x-text="paymentMethod === 'cod' ? 'Pesan Sekarang' : 'Bayar Sekarang'"></span>
                            <span>➔</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="step === 2" class="fixed inset-0 bg-white/95 backdrop-blur-sm flex items-center justify-center z-[100]" x-cloak x-transition.opacity>
            <div class="text-center">
                <div class="loader mx-auto mb-6"></div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Memproses...</h3>
                <p class="text-gray-500 text-sm">Mohon tunggu sebentar.</p>
            </div>
        </div>

        <div x-show="step === 3" class="max-w-xl mx-auto mt-8 pb-20" x-cloak x-transition>
            
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200 border border-white overflow-hidden relative text-center">
                <div class="bg-gray-50 py-8 border-b border-gray-100">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl shadow-sm border-4 border-white animate-bounce text-green-600" x-text="paymentMethod === 'cod' ? '📦' : '✅'"></div>
                    <h2 class="text-3xl font-black text-gray-800 mb-2" x-text="paymentMethod === 'cod' ? 'Pesanan Berhasil' : 'Menunggu Pembayaran'"></h2>
                    
                    <div x-show="paymentMethod !== 'cod'" class="inline-flex items-center gap-2 bg-white text-orange-600 px-4 py-1.5 rounded-full border border-orange-100 font-mono font-bold shadow-sm text-sm">
                        <span>⏱️</span> <span x-text="timerDisplay"></span>
                    </div>
                </div>
                
                <div class="p-10">
                    <template x-if="paymentMethod.includes('va') || ['alfa','indo','alfamidi','lawson','dandan'].includes(paymentMethod)">
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-8 relative">
                            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-3">Kode Pembayaran</p>
                            <span class="text-4xl font-mono font-black text-blue-900 tracking-widest block mb-6" x-text="vaNumber"></span>
                            <button @click="copyToClipboard(vaNumber)" class="text-xs font-bold bg-white text-blue-600 border border-blue-200 px-6 py-2.5 rounded-full hover:bg-blue-600 hover:text-white transition shadow-sm">SALIN KODE</button>
                        </div>
                    </template>

                    <template x-if="!paymentMethod.includes('va') && !['alfa','indo','alfamidi','lawson','dandan','cod'].includes(paymentMethod)">
                         <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Scan QR Code</p>
                            <div class="bg-white p-3 rounded-2xl shadow-lg border-2 border-gray-800 inline-block mx-auto">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BuildATeddyPayment" class="rounded-xl">
                            </div>
                        </div>
                    </template>

                    <template x-if="paymentMethod === 'cod'">
                        <div>
                             <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 inline-block w-full text-center">
                                <p class="text-sm font-bold text-orange-800 mb-2">Terima kasih!</p>
                                <p class="text-gray-600 text-sm">Pesananmu sedang disiapkan. Harap siapkan uang tunai pas saat kurir datang.</p>
                             </div>
                        </div>
                    </template>
                </div>

                <div class="bg-gray-900 p-4 text-center cursor-pointer hover:bg-gray-800 transition">
                    <a href="{{ route('history') }}" class="text-white font-bold block w-full h-full py-2">Cek Status Pesanan</a>
                </div>
            </div>
            
            <div class="text-center mt-6">
                <a href="{{ url('/') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600">Kembali ke Beranda</a>
            </div>
        </div>

    </div>
</body>
</html>