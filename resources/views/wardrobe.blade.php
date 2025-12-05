<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lemari Boneka Saya - Build-A-Teddy</title>
    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-orange-50/50 flex flex-col h-screen overflow-hidden">

    <!-- NAVBAR COMPACT -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 z-50 shadow-sm flex-none">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <span class="text-3xl">🧸</span>
                    <h1 class="text-xl font-extrabold text-orange-600 tracking-wide">Lemari Saya</h1>
                </a>
                <div class="flex gap-4 text-sm font-bold items-center">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600">Home</a>
                    <a href="{{ route('workshop') }}" class="text-orange-600 bg-orange-100 px-4 py-2 rounded-full hover:bg-orange-200 flex items-center gap-2">
                        <span>🛒</span> Shop
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT (Split Screen Layout) -->
    <div class="flex-grow flex flex-col h-full overflow-hidden relative"
         x-data="{ 
            // DATA DUMMY (Kosongkan array ini untuk mengetes tampilan Empty State!)
            myBears: [
                // { id: 1, name: 'Si Coklat', type: 'coklat' }, 
                // { id: 2, name: 'Si Panda', type: 'panda' }
            ],
            myOutfits: [
                // { id: 101, name: 'Kaos Merah', type: 'kaos' },
                // { id: 102, name: 'Hoodie Biru', type: 'hoodie' }
            ],
            myAccessories: [],
            
            activeBear: 'coklat', activeOutfit: 'none', activeAccessory: 'none',

            get bearColor() { 
                if(this.myBears.length === 0) return '#eee'; // Warna abu kalo kosong
                let type = this.activeBear;
                // Fallback cari boneka pertama kalo activeBear ga valid
                if(!this.myBears.find(b => b.type === this.activeBear) && this.myBears.length > 0) type = this.myBears[0].type;
                
                return type === 'coklat' ? '#8B4513' : (type === 'krem' ? '#F5DEB3' : '#333333'); 
            },
            get bearBellyColor() { 
                if(this.myBears.length === 0) return '#ddd';
                let type = this.activeBear;
                if(!this.myBears.find(b => b.type === this.activeBear) && this.myBears.length > 0) type = this.myBears[0].type;

                return type === 'coklat' ? '#D2691E' : (type === 'krem' ? '#FFF8DC' : '#FFFFFF'); 
            }
         }">

        <!-- TAMPILAN KOSONG (EMPTY STATE) -->
        <div x-show="myBears.length === 0" class="absolute inset-0 z-50 flex items-center justify-center bg-white" x-transition>
            <div class="text-center p-8 max-w-md">
                <div class="w-48 h-48 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <span class="text-8xl opacity-50 grayscale">🧸</span>
                    <span class="text-4xl absolute bottom-2 right-2">❓</span>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Keranjang Masih Kosong</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Wah, kamu belum mengadopsi boneka apapun. Yuk cari teman barumu di Workshop!
                </p>
                <a href="{{ route('workshop') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30 hover:bg-orange-700 hover:-translate-y-1 transition transform">
                    <span>🚀</span> Start Shopping
                </a>
            </div>
        </div>

        <!-- TAMPILAN ISI (JIKA DATA ADA) -->
        <div x-show="myBears.length > 0" class="flex flex-col md:flex-row h-full w-full">
            
            <!-- KIRI: PREVIEW AREA -->
            <div class="w-full md:w-[400px] lg:w-[450px] bg-white border-r border-orange-100 flex flex-col relative z-20 shadow-xl">
                <div class="flex-grow flex items-center justify-center p-6 bg-orange-50/30 relative">
                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-white/80 backdrop-blur px-4 py-1 rounded-full text-xs font-bold text-gray-500 shadow-sm border border-orange-100">
                        Cermin Ajaib ✨
                    </div>

                    <!-- SVG CANVAS -->
                    <div class="relative w-full max-w-[300px] aspect-[3/4] flex items-center justify-center">
                        <svg width="100%" height="100%" viewBox="0 0 200 250" class="absolute z-10 transition-all duration-500 drop-shadow-xl">
                            <circle cx="40" cy="50" r="25" :fill="bearColor" /><circle cx="40" cy="50" r="12" :fill="bearBellyColor" />
                            <circle cx="160" cy="50" r="25" :fill="bearColor" /><circle cx="160" cy="50" r="12" :fill="bearBellyColor" />
                            <ellipse cx="30" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(-20 30 140)" />
                            <ellipse cx="170" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(20 170 140)" />
                            <ellipse cx="60" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="60" cy="230" r="12" :fill="bearBellyColor" />
                            <ellipse cx="140" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="140" cy="230" r="12" :fill="bearBellyColor" />
                            <ellipse cx="100" cy="160" rx="65" ry="75" :fill="bearColor" /><ellipse cx="100" cy="160" rx="40" ry="50" :fill="bearBellyColor" />
                            <circle cx="100" cy="80" r="60" :fill="bearColor" /><ellipse cx="100" cy="90" rx="25" ry="20" :fill="bearBellyColor" />
                            <circle cx="90" cy="80" r="5" fill="#000" /><circle cx="110" cy="80" r="5" fill="#000" />
                            <ellipse cx="100" cy="88" rx="8" ry="6" fill="#3E2723" /><path d="M 95 95 Q 100 100 105 95" stroke="#3E2723" stroke-width="2" fill="none" />
                        </svg>

                        <div x-show="activeOutfit === 'kaos'" class="absolute z-20 top-[44%] w-[70%] left-[15%]"><svg viewBox="0 0 140 100"><path d="M 40 10 L 100 10 L 120 40 L 100 50 L 90 30 L 90 90 L 50 90 L 50 30 L 40 50 L 20 40 Z" fill="#EF4444" stroke="#B91C1C" stroke-width="2"/><text x="70" y="60" font-size="20" text-anchor="middle" fill="white" font-weight="bold">UAP</text></svg></div>
                        <div x-show="activeOutfit === 'hoodie'" class="absolute z-20 top-[42%] w-[75%] left-[12.5%]"><svg viewBox="0 0 150 110"><path d="M 45 5 L 105 5 L 130 40 L 110 55 L 100 35 L 100 100 L 50 100 L 50 35 L 40 55 L 20 40 Z" fill="#3B82F6" stroke="#1D4ED8" stroke-width="2"/><rect x="65" y="60" width="20" height="25" fill="#2563EB" rx="5" /></svg></div>
                        <div x-show="activeOutfit === 'dress'" class="absolute z-20 top-[44%] w-[70%] left-[15%]"><svg viewBox="0 0 140 120"><path d="M 50 10 L 90 10 L 110 90 L 30 90 Z" fill="#EC4899" /><path d="M 30 90 Q 70 110 110 90" fill="#EC4899" /></svg></div>
                        
                        <div x-show="activeAccessory === 'kacamata'" class="absolute z-30 top-[26%] w-[40%] left-[30%]"><svg viewBox="0 0 80 30"><circle cx="20" cy="15" r="12" fill="#000" opacity="0.8" /><circle cx="60" cy="15" r="12" fill="#000" opacity="0.8" /><line x1="32" y1="15" x2="48" y2="15" stroke="#000" stroke-width="2" /></svg></div>
                        <div x-show="activeAccessory === 'topi'" class="absolute z-30 top-[-4%] w-[50%] left-[25%]"><svg viewBox="0 0 100 80"><rect x="25" y="20" width="50" height="50" fill="#1F2937" /><rect x="10" y="65" width="80" height="10" fill="#1F2937" /><rect x="25" y="55" width="50" height="5" fill="#EF4444" /></svg></div>
                    </div>
                </div>

                <div class="p-6 border-t border-orange-100 bg-white">
                    <button class="w-full bg-gray-900 text-white py-4 rounded-2xl font-bold shadow-lg flex items-center justify-center gap-2 hover:bg-gray-800 transition">
                        📸 Simpan Foto
                    </button>
                    <button @click="activeOutfit='none'; activeAccessory='none'" class="w-full mt-3 text-gray-400 text-sm hover:text-orange-600 font-bold">
                        Reset Tampilan
                    </button>
                </div>
            </div>

            <!-- KANAN: INVENTORY -->
            <div class="flex-1 bg-gray-50 overflow-y-auto p-6 md:p-10 space-y-10">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Koleksi Saya</h2>

                    <!-- 1. BONEKA -->
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-600 mb-3 flex items-center gap-2">
                            <span class="bg-orange-100 p-1.5 rounded-lg text-lg">🐻</span> Boneka
                        </h3>
                        <div class="flex gap-4 overflow-x-auto pb-4 hide-scroll snap-x">
                            <template x-for="bear in myBears" :key="bear.id">
                                <div @click="activeBear = bear.type" 
                                     :class="activeBear === bear.type ? 'ring-4 ring-orange-200 border-orange-500' : 'border-gray-200 hover:border-orange-300'"
                                     class="snap-start flex-none w-32 h-40 bg-white border-2 rounded-2xl p-4 cursor-pointer transition flex flex-col items-center justify-center shadow-sm">
                                    <div class="w-16 h-16 rounded-full mb-3 shadow-inner" :style="'background-color: ' + (bear.type === 'coklat' ? '#8B4513' : (bear.type === 'panda' ? '#333' : '#F5DEB3'))"></div>
                                    <span class="text-sm font-bold text-gray-700" x-text="bear.name"></span>
                                </div>
                            </template>
                            <a href="{{ route('workshop') }}" class="snap-start flex-none w-32 h-40 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-gray-400 hover:text-orange-600 hover:border-orange-300 transition bg-white/50">
                                <span class="text-3xl font-light mb-1">+</span><span class="text-xs font-bold">Beli Baru</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. BAJU -->
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-600 mb-3 flex items-center gap-2">
                            <span class="bg-blue-100 p-1.5 rounded-lg text-lg">👕</span> Outfit
                        </h3>
                        <div class="flex gap-4 overflow-x-auto pb-4 hide-scroll snap-x">
                            <div @click="activeOutfit = 'none'" :class="activeOutfit === 'none' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 bg-white'" class="snap-start flex-none w-32 h-40 border-2 rounded-2xl p-4 cursor-pointer transition flex flex-col items-center justify-center shadow-sm">
                                <span class="text-3xl mb-2 grayscale opacity-50">❌</span><span class="text-xs font-bold text-gray-600">Lepas</span>
                            </div>
                            <template x-for="outfit in myOutfits" :key="outfit.id">
                                <div @click="activeOutfit = outfit.type" :class="activeOutfit === outfit.type ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 bg-white'" class="snap-start flex-none w-32 h-40 border-2 rounded-2xl p-4 cursor-pointer transition flex flex-col items-center justify-center shadow-sm">
                                    <span class="text-4xl mb-3">👕</span>
                                    <span class="text-sm font-bold text-gray-700 text-center leading-tight" x-text="outfit.name"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 3. AKSESORIS -->
                    <div>
                        <h3 class="font-bold text-gray-600 mb-3 flex items-center gap-2"><span class="bg-pink-100 p-1.5 rounded-lg text-lg">👓</span> Aksesoris</h3>
                        <div class="flex gap-4 overflow-x-auto pb-4 hide-scroll snap-x">
                            <div @click="activeAccessory = 'none'" :class="activeAccessory === 'none' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 bg-white'" class="snap-start flex-none w-32 h-40 border-2 rounded-2xl p-4 cursor-pointer transition flex flex-col items-center justify-center shadow-sm">
                                <span class="text-2xl mb-2 grayscale opacity-50">❌</span><span class="text-xs font-bold text-gray-600">Lepas</span>
                            </div>
                            <template x-for="acc in myAccessories" :key="acc.id">
                                <div @click="activeAccessory = acc.type" :class="activeAccessory === acc.type ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 bg-white'" class="snap-start flex-none w-32 h-40 border-2 rounded-2xl p-4 cursor-pointer transition flex flex-col items-center justify-center shadow-sm">
                                    <span class="text-4xl mb-2">🎩</span><span class="text-xs font-bold text-gray-700 leading-tight" x-text="acc.name"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>