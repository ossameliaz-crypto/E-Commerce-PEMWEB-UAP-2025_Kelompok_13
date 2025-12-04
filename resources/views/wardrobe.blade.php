<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lemari Boneka Saya - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-orange-50/50 flex flex-col min-h-screen">

    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <span class="text-4xl group-hover:animate-bounce">🧸</span>
                    <div>
                        <h1 class="text-2xl font-extrabold text-orange-600 tracking-wide leading-none">Build-A-Teddy</h1>
                        <span class="text-xs text-orange-400 font-bold tracking-widest">OFFICIAL STORE</span>
                    </div>
                </a>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Beranda</a>
                    <a href="{{ route('workshop') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Workshop</a>
                    <a href="#" class="text-orange-600 font-bold border-b-2 border-orange-500 py-1">Lemari Saya</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('workshop') }}" class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-bold hover:bg-orange-200 transition flex items-center gap-2">
                        <span>🛒</span> Beli Baru
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8"
          x-data="{ 
            myBears: [
                { id: 1, name: 'Si Coklat', type: 'coklat' },
                { id: 2, name: 'Si Panda', type: 'panda' }
            ],
            myOutfits: [
                { id: 101, name: 'Kaos Merah', type: 'kaos' },
                { id: 102, name: 'Hoodie Biru', type: 'hoodie' },
                { id: 103, name: 'Dress Pink', type: 'dress' }
            ],
            myAccessories: [
                { id: 201, name: 'Kacamata', type: 'kacamata' },
                { id: 202, name: 'Topi Sulap', type: 'topi' }
            ],
            activeBear: 'coklat', activeOutfit: 'none', activeAccessory: 'none',

            get bearColor() {
                if (this.activeBear === 'coklat') return '#8B4513';
                if (this.activeBear === 'krem') return '#F5DEB3';
                if (this.activeBear === 'panda') return '#333333';
                return '#8B4513';
            },
            get bearBellyColor() {
                if (this.activeBear === 'coklat') return '#D2691E';
                if (this.activeBear === 'krem') return '#FFF8DC';
                if (this.activeBear === 'panda') return '#FFFFFF';
                return '#D2691E';
            }
         }">
         
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900">Lemari Koleksi 🧥</h1>
                <p class="text-gray-500 mt-2">Mix and match semua item yang sudah kamu beli di sini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <div class="md:col-span-5 lg:col-span-4 sticky top-28">
                    <div class="bg-white rounded-3xl p-6 shadow-xl border-4 border-orange-200 relative">
                        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-orange-600 text-white px-6 py-2 rounded-full font-bold shadow-lg text-sm uppercase tracking-wide">
                            Preview Look
                        </div>

                        <div class="mt-4 relative w-full h-80 flex items-center justify-center bg-orange-50 rounded-2xl overflow-hidden border-2 border-dashed border-orange-300">
                            <svg width="220" height="280" viewBox="0 0 200 250" class="absolute z-10 transition-all duration-500">
                                <circle cx="40" cy="50" r="25" :fill="bearColor" /><circle cx="40" cy="50" r="12" :fill="bearBellyColor" />
                                <circle cx="160" cy="50" r="25" :fill="bearColor" /><circle cx="160" cy="50" r="12" :fill="bearBellyColor" />
                                <ellipse cx="30" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(-20 30 140)" />
                                <ellipse cx="170" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(20 170 140)" />
                                <ellipse cx="60" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="60" cy="230" r="12" :fill="bearBellyColor" />
                                <ellipse cx="140" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="140" cy="230" r="12" :fill="bearBellyColor" />
                                <ellipse cx="100" cy="160" rx="65" ry="75" :fill="bearColor" /><ellipse cx="100" cy="160" rx="40" ry="50" :fill="bearBellyColor" />
                                <circle cx="100" cy="80" r="60" :fill="bearColor" /><ellipse cx="100" cy="90" rx="25" ry="20" :fill="bearBellyColor" />
                                <circle cx="90" cy="80" r="5" fill="#000" /><circle cx="110" cy="80" r="5" fill="#000" />
                                <ellipse cx="100" cy="88" rx="8" ry="6" fill="#3E2723" />
                                <path d="M 95 95 Q 100 100 105 95" stroke="#3E2723" stroke-width="2" fill="none" />
                            </svg>

                            <div x-show="activeOutfit === 'kaos'" class="absolute z-20 top-[110px]" x-transition.enter><svg width="140" height="100" viewBox="0 0 140 100"><path d="M 40 10 L 100 10 L 120 40 L 100 50 L 90 30 L 90 90 L 50 90 L 50 30 L 40 50 L 20 40 Z" fill="#EF4444" stroke="#B91C1C" stroke-width="2"/><text x="70" y="60" font-size="20" text-anchor="middle" fill="white" font-weight="bold">UAP</text></svg></div>
                            <div x-show="activeOutfit === 'hoodie'" class="absolute z-20 top-[105px]" x-transition.enter><svg width="150" height="110" viewBox="0 0 150 110"><path d="M 45 5 L 105 5 L 130 40 L 110 55 L 100 35 L 100 100 L 50 100 L 50 35 L 40 55 L 20 40 Z" fill="#3B82F6" stroke="#1D4ED8" stroke-width="2"/><rect x="65" y="60" width="20" height="25" fill="#2563EB" rx="5" /></svg></div>
                            <div x-show="activeOutfit === 'dress'" class="absolute z-20 top-[110px]" x-transition.enter><svg width="140" height="120" viewBox="0 0 140 120"><path d="M 50 10 L 90 10 L 110 90 L 30 90 Z" fill="#EC4899" /><path d="M 30 90 Q 70 110 110 90" fill="#EC4899" /></svg></div>

                            <div x-show="activeAccessory === 'kacamata'" class="absolute z-30 top-[65px]" x-transition.enter><svg width="80" height="30" viewBox="0 0 80 30"><circle cx="20" cy="15" r="12" fill="#000" opacity="0.8" /><circle cx="60" cy="15" r="12" fill="#000" opacity="0.8" /><line x1="32" y1="15" x2="48" y2="15" stroke="#000" stroke-width="2" /></svg></div>
                            <div x-show="activeAccessory === 'topi'" class="absolute z-30 top-[-10px]" x-transition.enter><svg width="100" height="80" viewBox="0 0 100 80"><rect x="25" y="20" width="50" height="50" fill="#1F2937" /><rect x="10" y="65" width="80" height="10" fill="#1F2937" /><rect x="25" y="55" width="50" height="5" fill="#EF4444" /></svg></div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button class="flex-1 bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg flex items-center justify-center gap-2">
                                <span>📸</span> Capture
                            </button>
                            <button @click="activeOutfit='none'; activeAccessory='none'" class="flex-1 bg-white border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 transition">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-7 lg:col-span-8 space-y-8 pl-0 md:pl-8">
                    
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-orange-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                                <span class="bg-orange-100 p-2 rounded-lg">🐻</span> Koleksi Boneka
                            </h3>
                            <span class="text-xs text-gray-400 font-bold bg-gray-100 px-2 py-1 rounded-full" x-text="myBears.length + ' Item'"></span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <template x-for="bear in myBears" :key="bear.id">
                                <div @click="activeBear = bear.type" 
                                     :class="activeBear === bear.type ? 'ring-2 ring-orange-500 bg-orange-50 shadow-md transform scale-105' : 'bg-gray-50 hover:bg-gray-100'"
                                     class="rounded-2xl p-4 cursor-pointer transition text-center flex flex-col items-center justify-center h-32 border border-transparent">
                                    <div class="w-12 h-12 rounded-full mb-2 shadow-inner" :style="'background-color: ' + (bear.type === 'coklat' ? '#8B4513' : (bear.type === 'panda' ? '#333' : '#F5DEB3'))"></div>
                                    <span class="text-xs font-bold text-gray-700" x-text="bear.name"></span>
                                </div>
                            </template>
                            <a href="{{ route('workshop') }}" class="rounded-2xl p-4 border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-300 transition h-32 group">
                                <span class="text-3xl group-hover:scale-110 transition">+</span>
                                <span class="text-xs font-bold mt-1">Beli Lagi</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-orange-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                                <span class="bg-blue-100 p-2 rounded-lg">👕</span> Koleksi Baju
                            </h3>
                            <span class="text-xs text-gray-400 font-bold bg-gray-100 px-2 py-1 rounded-full" x-text="myOutfits.length + ' Item'"></span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <div @click="activeOutfit = 'none'" :class="activeOutfit === 'none' ? 'ring-2 ring-orange-500 bg-orange-50 shadow-md' : 'bg-gray-50 hover:bg-gray-100'" class="rounded-2xl p-4 cursor-pointer transition text-center flex flex-col items-center justify-center h-32 border border-transparent">
                                <span class="text-2xl mb-2">❌</span><span class="text-xs font-bold text-gray-700">Lepas Baju</span>
                            </div>
                            <template x-for="outfit in myOutfits" :key="outfit.id">
                                <div @click="activeOutfit = outfit.type" :class="activeOutfit === outfit.type ? 'ring-2 ring-orange-500 bg-orange-50 shadow-md transform scale-105' : 'bg-gray-50 hover:bg-gray-100'" class="rounded-2xl p-4 cursor-pointer transition text-center flex flex-col items-center justify-center h-32 border border-transparent">
                                    <span class="text-4xl mb-2">👕</span>
                                    <span class="text-xs font-bold text-gray-700 leading-tight" x-text="outfit.name"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-orange-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                                <span class="bg-pink-100 p-2 rounded-lg">👓</span> Aksesoris
                            </h3>
                            <span class="text-xs text-gray-400 font-bold bg-gray-100 px-2 py-1 rounded-full" x-text="myAccessories.length + ' Item'"></span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                             <div @click="activeAccessory = 'none'" :class="activeAccessory === 'none' ? 'ring-2 ring-orange-500 bg-orange-50 shadow-md' : 'bg-gray-50 hover:bg-gray-100'" class="rounded-2xl p-4 cursor-pointer transition text-center flex flex-col items-center justify-center h-32 border border-transparent">
                                <span class="text-2xl mb-2">❌</span><span class="text-xs font-bold text-gray-700">Lepas Acc</span>
                            </div>
                            <template x-for="acc in myAccessories" :key="acc.id">
                                <div @click="activeAccessory = acc.type" :class="activeAccessory === acc.type ? 'ring-2 ring-orange-500 bg-orange-50 shadow-md transform scale-105' : 'bg-gray-50 hover:bg-gray-100'" class="rounded-2xl p-4 cursor-pointer transition text-center flex flex-col items-center justify-center h-32 border border-transparent">
                                    <span class="text-4xl mb-2">🎩</span>
                                    <span class="text-xs font-bold text-gray-700 leading-tight" x-text="acc.name"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-2xl block mb-2">🧸</span>
            <p class="text-sm">
                &copy; 2025 Build-A-Teddy. Halaman Lemari Pribadi.
            </p>
        </div>
    </footer>

</body>
</html>