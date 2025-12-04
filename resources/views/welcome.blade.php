<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Build-A-Teddy Store</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .scroll-hidden::-webkit-scrollbar { display: none; }
        .scroll-hidden { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased bg-orange-50/50">

    <!-- 1. NAVBAR (Sticky & Glassmorphism) -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                    <span class="text-4xl animate-bounce">🧸</span>
                    <div>
                        <h1 class="text-2xl font-extrabold text-orange-600 tracking-wide leading-none">Build-A-Teddy</h1>
                        <span class="text-xs text-orange-400 font-bold tracking-widest">OFFICIAL STORE</span>
                    </div>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8">
                    <a href="#featured" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Koleksi</a>
                    <a href="{{ route('workshop') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Workshop</a>
                    <a href="{{ route('wardrobe') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Lemari Saya</a>
                    <a href="#seller" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Jadi Seller</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-bold hover:bg-orange-200 transition flex items-center gap-2">
                                <span>👤</span> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-orange-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold hover:shadow-lg transform hover:-translate-y-0.5 transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION (Besar & Menarik) -->
    <div class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20 px-4 sm:px-6 lg:px-8">
                <main class="mt-10 sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <div class="inline-block px-4 py-1 rounded-full bg-orange-100 text-orange-600 font-bold text-sm mb-4">
                            ✨ New Collection 2025
                        </div>
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl mb-6">
                            <span class="block xl:inline">Bikin Teman Baru</span>
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">Sesuai Imajinasimu</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Platform kustomisasi boneka #1 di Kampus. Pilih boneka dasarmu, mix-and-match outfit keren, dan adopsi mereka sekarang juga!
                        </p>
                        <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start gap-3">
                            <a href="{{ route('workshop') }}" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-orange-600 hover:bg-orange-700 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition md:w-auto">
                                🚀 Mulai Kustomisasi
                            </a>
                            <a href="#featured" class="w-full flex items-center justify-center px-8 py-4 border-2 border-orange-100 text-lg font-bold rounded-full text-orange-600 bg-white hover:bg-orange-50 transition md:w-auto">
                                Lihat Katalog
                            </a>
                        </div>
                        <!-- Statistik Kecil -->
                        <div class="mt-8 flex items-center gap-6 text-sm text-gray-500 sm:justify-center lg:justify-start">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 text-lg">1k+</span> Terjual
                            </div>
                            <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 text-lg">50+</span> Aksesoris
                            </div>
                            <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 text-lg">4.9</span> Rating
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Ilustrasi Kanan -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-orange-50 flex items-center justify-center overflow-hidden">
             <!-- Dekorasi Lingkaran -->
             <div class="absolute w-[500px] h-[500px] bg-orange-200 rounded-full opacity-30 blur-3xl -top-20 -right-20"></div>
             <!-- SVG Boneka Besar -->
             <svg width="450" height="450" viewBox="0 0 200 200" class="relative z-10 drop-shadow-2xl transform hover:scale-105 transition duration-700">
                <circle cx="50" cy="50" r="30" fill="#8B4513" />
                <circle cx="150" cy="50" r="30" fill="#8B4513" />
                <ellipse cx="100" cy="150" rx="80" ry="60" fill="#8B4513" />
                <circle cx="100" cy="90" r="70" fill="#8B4513" />
                <ellipse cx="100" cy="100" rx="30" ry="25" fill="#D2691E" />
                <circle cx="85" cy="85" r="5" fill="black" />
                <circle cx="115" cy="85" r="5" fill="black" />
                <ellipse cx="100" cy="95" rx="10" ry="8" fill="#3E2723" />
                <!-- Baju Hoodie -->
                <path d="M 40 130 Q 100 180 160 130" stroke="#3B82F6" stroke-width="20" stroke-linecap="round" fill="none" />
                <rect x="90" y="150" width="20" height="30" fill="white" opacity="0.2" rx="5"/>
            </svg>
        </div>
    </div>

    <!-- 3. WHY US SECTION (Mengapa Kami) -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-orange-600 font-bold tracking-wide uppercase text-sm">Kenapa Build-A-Teddy?</h2>
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Lebih Dari Sekedar Boneka
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-orange-50 p-8 rounded-2xl text-center hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm group-hover:scale-110 transition">🎨</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">100% Customizable</h4>
                    <p class="text-gray-600">Ganti baju, tambah kacamata, atau pakaikan topi sesuka hatimu.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-orange-50 p-8 rounded-2xl text-center hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm group-hover:scale-110 transition">🛡️</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Bahan Premium</h4>
                    <p class="text-gray-600">Dibuat dari bahan rasfur lembut yang aman untuk dipeluk seharian.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-orange-50 p-8 rounded-2xl text-center hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm group-hover:scale-110 transition">⚡</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pengiriman Kilat</h4>
                    <p class="text-gray-600">Pesan hari ini, langsung dikirim besok. Bisa COD area kampus!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. CATEGORY GRID (Navigasi Cepat) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Jelajahi Kategori</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Cat 1 -->
            <a href="{{ route('workshop') }}" class="relative h-40 rounded-2xl overflow-hidden group cursor-pointer shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                <div class="absolute bottom-4 left-4 z-20 text-white font-bold text-xl group-hover:translate-x-2 transition">🐻 Boneka</div>
                <div class="w-full h-full bg-orange-200 flex items-center justify-center text-6xl group-hover:scale-110 transition duration-500">🐻</div>
            </a>
            <!-- Cat 2 -->
            <a href="#accessories" class="relative h-40 rounded-2xl overflow-hidden group cursor-pointer shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                <div class="absolute bottom-4 left-4 z-20 text-white font-bold text-xl group-hover:translate-x-2 transition">👕 Baju</div>
                <div class="w-full h-full bg-blue-200 flex items-center justify-center text-6xl group-hover:scale-110 transition duration-500">👕</div>
            </a>
            <!-- Cat 3 -->
            <a href="#accessories" class="relative h-40 rounded-2xl overflow-hidden group cursor-pointer shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                <div class="absolute bottom-4 left-4 z-20 text-white font-bold text-xl group-hover:translate-x-2 transition">👓 Aksesoris</div>
                <div class="w-full h-full bg-pink-200 flex items-center justify-center text-6xl group-hover:scale-110 transition duration-500">👓</div>
            </a>
            <!-- Cat 4 -->
            <a href="{{ route('store.register') }}" class="relative h-40 rounded-2xl overflow-hidden group cursor-pointer shadow-md border-2 border-dashed border-orange-300">
                <div class="w-full h-full bg-white flex flex-col items-center justify-center text-orange-500 group-hover:bg-orange-50 transition">
                    <span class="text-4xl mb-2">+</span>
                    <span class="font-bold">Jadi Seller</span>
                </div>
            </a>
        </div>
    </div>

    <!-- 5. BEST SELLERS (Boneka Utuh) -->
    <div id="featured" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Teddy Terfavorit</h2>
                    <p class="text-gray-500 mt-2">Paling banyak diadopsi minggu ini.</p>
                </div>
                <a href="{{ route('workshop') }}" class="text-orange-600 font-bold hover:underline">Lihat Semua →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition relative group">
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full z-10">Hot</div>
                    <div class="h-64 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 relative overflow-hidden">
                        <!-- SVG Bear -->
                        <div class="transform group-hover:scale-110 transition duration-500">
                             <svg width="150" height="180" viewBox="0 0 200 250">
                                <circle cx="100" cy="80" r="60" fill="#8B4513" />
                                <circle cx="40" cy="50" r="25" fill="#8B4513" />
                                <circle cx="160" cy="50" r="25" fill="#8B4513" />
                                <ellipse cx="100" cy="160" rx="65" ry="75" fill="#8B4513" />
                                <ellipse cx="100" cy="90" rx="25" ry="20" fill="#D2691E" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Classic Choco</h3>
                    <p class="text-sm text-gray-500 mb-4">Si klasik yang selalu setia.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-extrabold text-orange-600">Rp 150.000</span>
                        <a href="{{ route('workshop') }}" class="bg-gray-900 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-orange-600 transition">+</a>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition relative group">
                    <div class="h-64 bg-gray-100 rounded-2xl flex items-center justify-center mb-6 relative overflow-hidden">
                        <div class="transform group-hover:scale-110 transition duration-500">
                             <svg width="150" height="180" viewBox="0 0 200 250">
                                <circle cx="100" cy="80" r="60" fill="#333" />
                                <circle cx="40" cy="50" r="25" fill="#333" />
                                <circle cx="160" cy="50" r="25" fill="#333" />
                                <ellipse cx="100" cy="160" rx="65" ry="75" fill="#333" />
                                <ellipse cx="100" cy="160" rx="40" ry="50" fill="white" />
                                <ellipse cx="100" cy="90" rx="25" ry="20" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Mr. Panda</h3>
                    <p class="text-sm text-gray-500 mb-4">Hitam putih yang elegan.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-extrabold text-orange-600">Rp 165.000</span>
                        <a href="{{ route('workshop') }}" class="bg-gray-900 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-orange-600 transition">+</a>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition relative group">
                    <div class="h-64 bg-yellow-50 rounded-2xl flex items-center justify-center mb-6 relative overflow-hidden">
                        <div class="transform group-hover:scale-110 transition duration-500">
                             <svg width="150" height="180" viewBox="0 0 200 250">
                                <circle cx="100" cy="80" r="60" fill="#F5DEB3" />
                                <circle cx="40" cy="50" r="25" fill="#F5DEB3" />
                                <circle cx="160" cy="50" r="25" fill="#F5DEB3" />
                                <ellipse cx="100" cy="160" rx="65" ry="75" fill="#F5DEB3" />
                                <ellipse cx="100" cy="90" rx="25" ry="20" fill="#FFF8DC" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Vanilla Cream</h3>
                    <p class="text-sm text-gray-500 mb-4">Lembut dan manis dipandang.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-extrabold text-orange-600">Rp 150.000</span>
                        <a href="{{ route('workshop') }}" class="bg-gray-900 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-orange-600 transition">+</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. PROMO BANNER (SELLER) -->
    <div id="seller" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-3xl overflow-hidden relative shadow-2xl flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 p-12 relative z-10">
                    <span class="text-orange-400 font-bold tracking-widest uppercase text-sm">Community</span>
                    <h2 class="text-4xl font-extrabold text-white mt-2 mb-6 leading-tight">
                        Punya Bakat Menjahit? <br>
                        <span class="text-orange-500">Buka Toko Disini!</span>
                    </h2>
                    <p class="text-gray-400 mb-8 text-lg">
                        Bergabung dengan ratusan kreator lain. Jual baju boneka buatanmu sendiri dan dapatkan penghasilan tambahan.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('store.register') }}" class="bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-orange-50 transition">
                            Daftar Seller
                        </a>
                        <a href="#" class="border border-gray-600 text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">
                            Pelajari Dulu
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 h-full relative">
                    <!-- Pattern -->
                    <div class="absolute inset-0 bg-orange-600 opacity-20 transform -skew-x-12 scale-150"></div>
                    <div class="relative z-10 p-10 flex justify-center text-9xl">
                        🏪
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7. ACCESSORIES LIST (Grid Kecil) -->
    <div id="accessories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Aksesoris Terbaru</h2>
            <p class="mt-4 text-gray-500">Lengkapi koleksi baju bonekamu.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Item A1 -->
            <div class="group bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition">
                <div class="h-40 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-4 group-hover:scale-105 transition">👕</div>
                <h3 class="font-bold text-gray-800">Kaos Polos</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-orange-600 font-bold">Rp 35.000</span>
                    <button class="bg-orange-100 text-orange-600 w-8 h-8 rounded-full font-bold hover:bg-orange-200">+</button>
                </div>
            </div>
             <!-- Item A2 -->
             <div class="group bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition">
                <div class="h-40 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-4 group-hover:scale-105 transition">🧥</div>
                <h3 class="font-bold text-gray-800">Jaket Denim</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-orange-600 font-bold">Rp 65.000</span>
                    <button class="bg-orange-100 text-orange-600 w-8 h-8 rounded-full font-bold hover:bg-orange-200">+</button>
                </div>
            </div>
             <!-- Item A3 -->
             <div class="group bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition">
                <div class="h-40 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-4 group-hover:scale-105 transition">👓</div>
                <h3 class="font-bold text-gray-800">Kacamata Hitam</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-orange-600 font-bold">Rp 25.000</span>
                    <button class="bg-orange-100 text-orange-600 w-8 h-8 rounded-full font-bold hover:bg-orange-200">+</button>
                </div>
            </div>
             <!-- Item A4 -->
             <div class="group bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition">
                <div class="h-40 bg-gray-50 rounded-xl flex items-center justify-center text-5xl mb-4 group-hover:scale-105 transition">🎩</div>
                <h3 class="font-bold text-gray-800">Topi Sulap</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-orange-600 font-bold">Rp 40.000</span>
                    <button class="bg-orange-100 text-orange-600 w-8 h-8 rounded-full font-bold hover:bg-orange-200">+</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 8. TESTIMONIALS (Social Proof) -->
    <div class="bg-orange-600 py-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold mb-12">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Review 1 -->
                <div class="bg-orange-700 p-8 rounded-2xl relative">
                    <div class="text-4xl absolute -top-4 left-8">❝</div>
                    <p class="mb-6 italic opacity-90">"Lucu banget! Bahannya lembut dan pengirimannya cepet banget. Pas buat kado wisuda pacar."</p>
                    <div class="font-bold">- Anya, Mahasiswa FILKOM</div>
                </div>
                <!-- Review 2 -->
                <div class="bg-white text-orange-900 p-8 rounded-2xl relative transform md:scale-110 shadow-xl">
                    <div class="text-4xl absolute -top-4 left-8 text-orange-300">❝</div>
                    <p class="mb-6 italic">"Fitur workshop-nya keren parah. Bisa liat preview baju sebelum beli, jadi gak takut salah pilih warna."</p>
                    <div class="font-bold">- Budi, Anak Teknik</div>
                    <div class="mt-2 text-yellow-500 text-sm">⭐⭐⭐⭐⭐</div>
                </div>
                <!-- Review 3 -->
                <div class="bg-orange-700 p-8 rounded-2xl relative">
                    <div class="text-4xl absolute -top-4 left-8">❝</div>
                    <p class="mb-6 italic opacity-90">"Baru tau ada web ginian di kampus. Lumayan buat koleksi boneka di kosan biar gak sepi."</p>
                    <div class="font-bold">- Citra, Mahasiswa FEB</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 9. TIPS & BLOG -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-8">Tips Merawat Teddy</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex gap-4 items-start">
                    <div class="bg-orange-100 p-3 rounded-lg text-2xl">🚿</div>
                    <div>
                        <h4 class="font-bold text-lg">Cara Mencuci</h4>
                        <p class="text-gray-600 text-sm">Gunakan air dingin dan deterjen bayi. Jangan diperas terlalu kuat agar bulu tetap lembut.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="bg-orange-100 p-3 rounded-lg text-2xl">🌞</div>
                    <div>
                        <h4 class="font-bold text-lg">Menjemur</h4>
                        <p class="text-gray-600 text-sm">Hindari sinar matahari langsung. Angin-anginkan saja agar warna tidak pudar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 10. FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <span class="text-2xl">🧸</span>
                <h3 class="text-white text-lg font-bold mt-2">Build-A-Teddy</h3>
                <p class="mt-4 text-sm max-w-xs">
                    Platform e-commerce boneka custom pertama di Universitas Brawijaya. Dibuat dengan cinta dan kode.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('workshop') }}" class="hover:text-white">Workshop</a></li>
                    <li><a href="{{ route('wardrobe') }}" class="hover:text-white">Lemari Saya</a></li>
                    <li><a href="{{ route('store.register') }}" class="hover:text-white">Jadi Seller</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm">
                    <li>Malang, Jawa Timur</li>
                    <li>support@buildateddy.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-gray-800 text-center text-sm">
            &copy; 2025 Kelompok 13 Web Programming. All rights reserved.
        </div>
    </footer>

</body>
</html>