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
        [x-cloak] { display: none !important; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #f97316;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-orange-50/50 min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <span class="text-4xl">🧸</span>
                    <h1 class="text-2xl font-extrabold text-orange-600 tracking-wide">Build-A-Teddy</h1>
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="flex-grow flex items-center justify-center p-6"
         x-data="{ 
            step: 1, vaCode: '', amount: 0, isLoading: false,
            checkBill() {
                if(this.vaCode.length < 5) return alert('Kode VA minimal 5 digit!');
                this.step = 2; this.isLoading = true;
                setTimeout(() => { this.isLoading = false; this.step = 3; this.amount = 150000; }, 1500);
            },
            payBill() {
                this.step = 2; setTimeout(() => { this.step = 4; }, 1500);
            }
         }">

        <div class="w-full max-w-lg bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-orange-100 relative">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-8 text-center text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                <h2 class="text-2xl font-bold tracking-wider">TeddyPay Gateway</h2>
                <p class="text-orange-100 text-sm mt-1">Transaksi Aman & Terpercaya</p>
            </div>

            <div class="p-8">
                <div x-show="step === 1" x-transition>
                    <label class="block text-gray-700 font-bold mb-3">Masukkan Kode Virtual Account</label>
                    <input type="text" x-model="vaCode" placeholder="8800xxxxxxx" 
                           class="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition text-2xl font-mono text-center tracking-widest text-gray-800 mb-6 placeholder-gray-300">
                    <button @click="checkBill()" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-2xl shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                        Lanjut Pembayaran
                    </button>
                    <a href="{{ url('/') }}" class="block text-center mt-6 text-gray-400 text-sm hover:text-orange-500">Batal Transaksi</a>
                </div>

                <div x-show="step === 2" class="flex flex-col items-center justify-center py-12" x-cloak>
                    <div class="loader mb-4"></div>
                    <p class="text-gray-500 font-bold animate-pulse">Memproses...</p>
                </div>

                <div x-show="step === 3" x-cloak>
                    <div class="text-center mb-8">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Tagihan</span>
                        <h1 class="text-4xl font-extrabold text-gray-800 mt-2">Rp <span x-text="amount.toLocaleString('id-ID')"></span></h1>
                    </div>
                    <div class="bg-orange-50 p-6 rounded-2xl mb-6 space-y-3 border border-orange-100">
                        <div class="flex justify-between text-sm"><span class="text-gray-500">Merchant</span><span class="font-bold">Build-A-Teddy</span></div>
                        <div class="flex justify-between text-sm"><span class="text-gray-500">Kode VA</span><span class="font-mono font-bold" x-text="vaCode"></span></div>
                    </div>
                    <button @click="payBill()" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-2xl shadow-lg transition">Konfirmasi Bayar</button>
                </div>

                <div x-show="step === 4" class="text-center py-8" x-cloak>
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl">✅</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Sukses!</h2>
                    <p class="text-gray-500 mb-8">Barangmu sedang diproses.</p>
                    <a href="{{ url('/') }}" class="block w-full bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-gray-800 transition">Kembali ke Toko</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>