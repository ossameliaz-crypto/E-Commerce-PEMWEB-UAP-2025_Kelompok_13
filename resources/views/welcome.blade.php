<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build-A-Teddy | The Stuff You Love</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        h1, h2, h3, h4, .font-display { font-family: 'Fredoka', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased bg-white">

    <!-- 1. TOP PROMO BAR -->
    <div class="bg-orange-600 text-white text-center py-2 text-xs md:text-sm font-bold tracking-wider uppercase">
        🌍 Pengiriman ke Seluruh Indonesia! Gratis Ongkir Min. Belanja 200rb 🚚
    </div>

    <!-- 2. NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <span class="text-4xl group-hover:rotate-12 transition transform duration-300">🧸</span>
                    <div class="leading-tight">
                        <h1 class="text-2xl font-display font-extrabold text-orange-600 tracking-wide">BUILD-A-TEDDY</h1>
                        <span class="text-[10px] font-bold tracking-[0.2em] text-gray-400 uppercase group-hover:text-orange-400 transition">Official Store</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('workshop') }}" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Workshop</a>
                    <a href="#collection" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Katalog</a>
                    <a href="#reviews" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Ulasan</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center gap-5">
                    <a href="{{ route('wardrobe') }}" class="relative group">
                        <svg class="w-7 h-7 text-gray-600 group-hover:text-orange-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        
                        <!-- [UPDATED] Badge Keranjang: Default 0, Dinamis jika backend mengirim data -->
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full font-bold">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold border-2 border-transparent hover:border-orange-300 transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-orange-600 text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-orange-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. HERO BANNER -->
    <div class="relative bg-orange-50 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#ea580c 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-transparent sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 px-4 sm:px-6 lg:px-8">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 text-xs font-extrabold tracking-wider uppercase mb-4 animate-pulse">✨ New Experience</span>
                        <h1 class="text-4xl tracking-tight font-display font-extrabold text-gray-900 sm:text-5xl md:text-6xl leading-tight">
                            <span class="block">Teman Terbaik</span>
                            <span class="block text-orange-600">Bikin Sendiri!</span>
                        </h1>
                        <p class="mt-4 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Masuk ke <b>The Workshop</b>, pilih karakter dasar, dan dandani dengan ribuan outfit unik karya desainer lokal & kreator berbakat.
                        </p>
                        <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start gap-4">
                            <a href="{{ route('workshop') }}" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-2xl text-white bg-orange-600 hover:bg-orange-700 shadow-xl shadow-orange-500/30 transform hover:-translate-y-1 transition md:w-auto">
                                🚀 Mulai Workshop
                            </a>
                            <a href="{{ route('store.register') }}" class="w-full flex items-center justify-center px-8 py-4 border-2 border-orange-100 text-lg font-bold rounded-2xl text-orange-600 bg-white hover:bg-orange-50 transition md:w-auto">
                                Gabung Kreator
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <!-- Ilustrasi Kanan -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex items-end justify-center">
             <svg width="600" height="600" viewBox="0 0 200 200" class="transform translate-y-10 lg:translate-x-10 drop-shadow-2xl">
                <circle cx="50" cy="60" r="35" fill="#8B4513" />
                <circle cx="150" cy="60" r="35" fill="#8B4513" />
                <ellipse cx="100" cy="160" rx="90" ry="70" fill="#8B4513" />
                <circle cx="100" cy="100" r="75" fill="#8B4513" />
                <ellipse cx="100" cy="110" rx="35" ry="30" fill="#D2691E" />
                <circle cx="80" cy="90" r="6" fill="black" />
                <circle cx="120" cy="90" r="6" fill="black" />
                <ellipse cx="100" cy="105" rx="12" ry="8" fill="#3E2723" />
                <path d="M 40 160 Q 100 220 160 160" stroke="#f97316" stroke-width="30" stroke-linecap="round" fill="none" />
            </svg>
        </div>
    </div>

    <!-- 4. KATEGORI (Updated: Pilih Wangi) -->
    <div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-extrabold text-center text-gray-800 mb-10">Mulai Petualanganmu</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <a href="{{ route('workshop') }}" class="group">
                <div class="w-40 h-40 mx-auto rounded-full bg-orange-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 group-hover:border-orange-400 transition duration-300">
                    <span class="text-6xl group-hover:rotate-12 transition">🐻</span>
                </div>
                <h3 class="mt-4 font-bold text-lg text-gray-700 group-hover:text-orange-600">Pilih Boneka</h3>
            </a>
            <a href="{{ route('workshop') }}" class="group">
                <div class="w-40 h-40 mx-auto rounded-full bg-blue-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 group-hover:border-blue-400 transition duration-300">
                    <span class="text-6xl group-hover:-rotate-12 transition">👕</span>
                </div>
                <h3 class="mt-4 font-bold text-lg text-gray-700 group-hover:text-blue-600">Pilih Outfit</h3>
            </a>
            <a href="{{ route('workshop') }}" class="group">
                <div class="w-40 h-40 mx-auto rounded-full bg-pink-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 group-hover:border-pink-400 transition duration-300">
                    <span class="text-6xl group-hover:scale-110 transition">🎤</span>
                </div>
                <h3 class="mt-4 font-bold text-lg text-gray-700 group-hover:text-pink-600">Rekam Suara</h3>
            </a>
            <!-- Kategori ke-4: Pilih Wangi (Updated) -->
            <a href="{{ route('workshop') }}" class="group">
                <div class="w-40 h-40 mx-auto rounded-full bg-purple-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 group-hover:border-purple-400 transition duration-300">
                    <span class="text-6xl group-hover:rotate-12 transition">🌸</span>
                </div>
                <h3 class="mt-4 font-bold text-lg text-gray-700 group-hover:text-purple-600">Pilih Wangi</h3>
            </a>
        </div>
    </div>

    <!-- 5. NEW ARRIVALS -->
    <div id="collection" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-display font-extrabold text-gray-900">Koleksi Terbaru</h2>
                    <p class="text-gray-500 mt-2 font-medium">Item paling hits minggu ini.</p>
                </div>
                <a href="{{ route('workshop') }}" class="text-orange-600 font-bold hover:underline">Lihat Semua →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product Cards -->
                <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition group border border-gray-100">
                    <div class="aspect-square bg-orange-50 rounded-2xl flex items-center justify-center mb-4 relative overflow-hidden">
                        <span class="text-6xl group-hover:scale-110 transition">🧸</span>
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">HOT</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Classic Choco</h3>
                    <p class="text-xs text-gray-500 mb-3">Base Body</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-extrabold text-orange-600">Rp 150rb</span>
                        <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-600 hover:text-white flex items-center justify-center transition">+</button>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition group border border-gray-100">
                    <div class="aspect-square bg-blue-50 rounded-2xl flex items-center justify-center mb-4 relative overflow-hidden">
                        <span class="text-6xl group-hover:scale-110 transition">🧥</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Hoodie Biru</h3>
                    <p class="text-xs text-gray-500 mb-3">Outfit by <b>Urban Style</b></p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-extrabold text-orange-600">Rp 75rb</span>
                        <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-600 hover:text-white flex items-center justify-center transition">+</button>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition group border border-gray-100">
                    <div class="aspect-square bg-pink-50 rounded-2xl flex items-center justify-center mb-4 relative overflow-hidden">
                        <span class="text-6xl group-hover:scale-110 transition">👗</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Dress Pink</h3>
                    <p class="text-xs text-gray-500 mb-3">Outfit by <b>Cute Stuff</b></p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-extrabold text-orange-600">Rp 65rb</span>
                        <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-600 hover:text-white flex items-center justify-center transition">+</button>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition group border border-gray-100">
                    <div class="aspect-square bg-green-50 rounded-2xl flex items-center justify-center mb-4 relative overflow-hidden">
                        <span class="text-6xl group-hover:scale-110 transition">👓</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Kacamata Hitam</h3>
                    <p class="text-xs text-gray-500 mb-3">Accs by <b>Retro Vibe</b></p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-extrabold text-orange-600">Rp 25rb</span>
                        <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-600 hover:text-white flex items-center justify-center transition">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. ULASAN (TESTIMONIALS) -->
    <div id="reviews" class="bg-orange-600 py-16 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl font-display font-extrabold mb-12">Cerita Sahabat Teddy</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-orange-700 p-8 rounded-3xl relative hover:bg-orange-800 transition shadow-lg">
                    <div class="text-5xl absolute -top-6 left-8 text-orange-300">❝</div>
                    <p class="mb-6 italic text-orange-100 font-medium">"Kualitas bonekanya premium banget! Lembut dan aman buat adikku. Pengiriman juga super cepat."</p>
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold">A</div>
                        <div class="text-left">
                            <div class="font-bold">Anya S.</div>
                            <div class="text-xs text-orange-200">Jakarta</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white text-orange-900 p-8 rounded-3xl relative transform md:scale-110 shadow-2xl">
                    <div class="text-5xl absolute -top-6 left-8 text-orange-200">❝</div>
                    <p class="mb-6 italic font-medium">"Fitur rekam suaranya keren parah! Jadi kado wisuda paling berkesan buat pacar. Makasih Build-A-Teddy!"</p>
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold">B</div>
                        <div class="text-left">
                            <div class="font-bold">Budi Pratama</div>
                            <div class="text-xs text-gray-500">Bandung</div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-center text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="bg-orange-700 p-8 rounded-3xl relative hover:bg-orange-800 transition shadow-lg">
                    <div class="text-5xl absolute -top-6 left-8 text-orange-300">❝</div>
                    <p class="mb-6 italic text-orange-100 font-medium">"Seneng banget bisa beli baju boneka dari desainer lokal. Modelnya lucu-lucu dan gak pasaran."</p>
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold">C</div>
                        <div class="text-left">
                            <div class="font-bold">Citra Kirana</div>
                            <div class="text-xs text-orange-200">Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7. SELLER BANNER -->
    <div id="sellers" class="py-20 px-4">
        <div class="max-w-7xl mx-auto bg-gray-900 rounded-[3rem] overflow-hidden relative shadow-2xl flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 p-12 md:p-16 relative z-10 text-white">
                <span class="text-orange-400 font-bold tracking-widest uppercase text-xs mb-2 block">Komunitas Kreator Indonesia</span>
                <h2 class="text-4xl md:text-5xl font-display font-extrabold mb-6 leading-tight">
                    Punya Hobi Jahit?<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500">Jadilah Seller!</span>
                </h2>
                <p class="text-gray-400 mb-8 text-lg font-medium">
                    Gabung dengan ribuan kreator lain. Upload desain bajumu, kami sediakan bonekanya. Cuan ngalir dari rumah!
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('store.register') }}" class="bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-orange-700 transition shadow-lg transform hover:-translate-y-1">
                        Buka Toko Gratis
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 h-full relative flex items-center justify-center p-10">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-purple-600/20"></div>
                <span class="text-9xl relative z-10 drop-shadow-2xl filter animate-bounce">🏪</span>
            </div>
        </div>
    </div>

    <!-- 8. TIPS PERAWATAN (TEDDY CARE) -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-display font-extrabold text-gray-800">Teddy Care Guide 🏥</h2>
                <p class="text-gray-500 mt-2 font-medium">Tips agar boneka kesayanganmu awet selamanya.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex gap-6 items-start bg-orange-50 p-6 rounded-3xl border border-orange-100 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl shadow-sm">🚿</div>
                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-2">Spa Day (Mencuci)</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Gunakan air dingin dan deterjen bayi yang lembut. Cuci manual dengan tangan (jangan pakai mesin cuci) agar bulu tetap halus. Jangan diperas terlalu kuat ya!
                        </p>
                    </div>
                </div>
                <div class="flex gap-6 items-start bg-orange-50 p-6 rounded-3xl border border-orange-100 hover:shadow-md transition">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl shadow-sm">🌞</div>
                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-2">Sunbathing (Menjemur)</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Hindari menjemur di bawah sinar matahari langsung agar warna tidak pudar. Cukup diangin-anginkan di tempat teduh sampai kering sempurna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 9. LACAK PESANAN -->
    <div id="track-order" class="py-16 bg-orange-50">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <span class="text-4xl mb-4 block">🚚</span>
            <h2 class="text-3xl font-display font-extrabold text-gray-800 mb-4">Lacak Paketmu</h2>
            <p class="text-gray-600 mb-8">Masukkan nomor resi atau Order ID untuk melihat posisi Teddy-mu sekarang.</p>
            <form action="{{ route('history') }}" method="GET" class="bg-white p-2 rounded-full shadow-lg border border-orange-100 flex transition hover:shadow-xl">
                <input type="text" placeholder="Contoh: TRX-88291..." class="flex-1 px-6 py-4 rounded-l-full outline-none text-gray-700 font-bold placeholder-gray-300">
                <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-full font-bold hover:bg-orange-700 transition">
                    Cek Resi
                </button>
            </form>
            <div class="mt-6 flex justify-center gap-6 text-sm font-bold text-gray-400">
                <span class="flex items-center gap-2">✅ Real-time Update</span>
                <span class="flex items-center gap-2">🛡️ Garansi Pengiriman</span>
            </div>
        </div>
    </div>

    <!-- 10. FOOTER -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-5xl block mb-4">🧸</span>
            <h3 class="text-orange-600 font-display font-extrabold text-2xl mb-8 tracking-wide">BUILD-A-TEDDY</h3>
            <div class="flex flex-wrap justify-center gap-8 mb-8 text-gray-500 font-bold text-sm">
                <a href="#" class="hover:text-orange-600 transition">Tentang Kami</a>
                <a href="#" class="hover:text-orange-600 transition">Kebijakan Seller</a>
                <a href="#" class="hover:text-orange-600 transition">Lokasi Store</a>
                <a href="#" class="hover:text-orange-600 transition">Hubungi Kami</a>
            </div>
            <p class="text-gray-400 text-xs">
                &copy; 2025 Build-A-Teddy Indonesia. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
