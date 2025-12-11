<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build-A-Teddy | The Stuff You Love</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, h4, .font-display { font-family: 'Fredoka', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        .interactive-card:hover {
            box-shadow: 0 15px 30px -5px rgba(234, 88, 12, 0.3);
            transform: translateY(-5px);
        }
        .interactive-icon:hover {
            transform: scale(1.15) rotate(5deg);
            filter: drop-shadow(0 4px 10px rgba(234, 88, 12, 0.5));
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: { 50: '#fff7ed', 100: '#ffedd5', 500: '#f97316', 600: '#ea580c', 700: '#c2410c' }
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-[#FFFBF5] text-gray-800">

    <div class="bg-orange-600 text-white text-center py-2 text-xs md:text-sm font-bold tracking-wider uppercase">
        🌍 Pengiriman ke Seluruh Indonesia! Gratis Ongkir Min. Belanja 200rb 🚚
    </div>

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm" x-data="{ openProfile: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <span class="text-4xl group-hover:rotate-12 transition transform duration-300">🧸</span>
                    <div class="leading-tight">
                        <span class="font-display font-extrabold text-orange-600 text-2xl tracking-wide block">BUILD-A-TEDDY</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] group-hover:text-orange-400 transition">Official Store</span>
                    </div>
                </a>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('workshop') }}" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Workshop</a>
                    <a href="#collection" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Katalog</a>
                    <a href="#reviews" class="text-gray-600 font-bold hover:text-orange-600 border-b-2 border-transparent hover:border-orange-500 py-1 transition">Ulasan</a>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('wardrobe') }}" class="relative group">
                        <span class="text-2xl text-gray-600 group-hover:text-orange-600 transition">🛍️</span>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>

                    @auth
                        <div class="relative">
                            <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-3 focus:outline-none hover:bg-orange-50 py-1 px-2 rounded-lg transition">
                                <div class="w-9 h-9 bg-orange-100 rounded-full border-2 border-orange-200 flex items-center justify-center font-display font-bold text-orange-600 text-lg group-hover:bg-orange-600 group-hover:text-white transition shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div x-show="openProfile" x-transition class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-100 bg-orange-50/50">
                                    <p class="text-xs text-orange-400 font-bold uppercase tracking-wider">Signed in as</p>
                                    <p class="text-sm font-display font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-3 text-sm font-bold text-gray-600 hover:bg-orange-50 hover:text-orange-600">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm font-bold text-gray-600 hover:bg-orange-50 hover:text-orange-600">Pengaturan Akun</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-orange-600 text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-orange-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-orange-50 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(#ea580c 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-transparent sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 px-4 sm:px-6 lg:px-8">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <span class="inline-block py-1.5 px-4 rounded-full bg-orange-100 text-orange-600 text-xs font-extrabold tracking-wider uppercase mb-6 animate-pulse border border-orange-200 shadow-md">✨ New Experience</span>
                        <h1 class="text-5xl tracking-tight font-display font-extrabold text-gray-900 sm:text-6xl md:text-7xl leading-tight">
                            <span class="block">Teman Terbaik</span>
                            <span class="block text-orange-600">Bikin Sendiri!</span>
                        </h1>
                        <p class="mt-6 text-base text-gray-600 sm:mt-8 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-8 md:text-xl lg:mx-0 font-medium leading-relaxed">
                            Masuk ke The Workshop, pilih karakter dasar, dan dandani dengan ribuan outfit unik karya desainer lokal & kreator berbakat.
                        </p>
                        <div class="mt-10 sm:mt-12 sm:flex sm:justify-center lg:justify-start gap-4">
                            <a href="{{ route('workshop') }}" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-2xl text-white bg-orange-600 hover:bg-orange-700 shadow-2xl shadow-orange-500/50 transform hover:-translate-y-1 transition md:w-auto gap-2">
                                🚀 Mulai Workshop
                            </a>
                            <a href="{{ route('store.register') }}" class="w-full flex items-center justify-center px-8 py-4 border-2 border-orange-200 text-lg font-bold rounded-2xl text-orange-600 bg-white hover:bg-orange-50 transition md:w-auto hover:border-orange-300">
                                Gabung Kreator
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex items-end justify-center pointer-events-none">
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

    <div class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-extrabold text-center text-gray-800 mb-12">Mulai Petualanganmu</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
            <a href="{{ route('workshop') }}" class="group transition duration-300">
                <div class="w-32 h-32 mx-auto rounded-[2rem] bg-orange-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-105 group-hover:border-orange-400 group-hover:shadow-orange-200 transition duration-300 interactive-card">
                    <span class="text-6xl group-hover:rotate-3 transition interactive-icon">🐻</span>
                </div>
                <h3 class="mt-5 font-bold text-lg text-gray-700 group-hover:text-orange-600 transition">Pilih Boneka</h3>
            </a>
            <a href="{{ route('workshop') }}" class="group transition duration-300">
                <div class="w-32 h-32 mx-auto rounded-[2rem] bg-blue-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-105 group-hover:border-blue-400 group-hover:shadow-blue-200 transition duration-300 interactive-card">
                    <span class="text-6xl group-hover:rotate-3 transition interactive-icon">👕</span>
                </div>
                <h3 class="mt-5 font-bold text-lg text-gray-700 group-hover:text-orange-600 transition">Pilih Outfit</h3>
            </a>
            <a href="{{ route('workshop') }}" class="group transition duration-300">
                <div class="w-32 h-32 mx-auto rounded-[2rem] bg-pink-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-105 group-hover:border-pink-400 group-hover:shadow-pink-200 transition duration-300 interactive-card">
                    <span class="text-6xl group-hover:scale-110 transition interactive-icon">🎤</span>
                </div>
                <h3 class="mt-5 font-bold text-lg text-gray-700 group-hover:text-orange-600 transition">Rekam Suara</h3>
            </a>
            <a href="{{ route('workshop') }}" class="group transition duration-300">
                <div class="w-32 h-32 mx-auto rounded-[2rem] bg-purple-100 flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-105 group-hover:border-purple-400 group-hover:shadow-purple-200 transition duration-300 interactive-card">
                    <span class="text-6xl group-hover:rotate-3 transition interactive-icon">🌸</span>
                </div>
                <h3 class="mt-5 font-bold text-lg text-gray-700 group-hover:text-orange-600 transition">Pilih Wangi</h3>
            </a>
        </div>
    </div>

    <div id="collection" class="bg-white py-20 border-t border-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-display font-extrabold text-gray-900">Koleksi Terbaru</h2>
                    <p class="text-gray-500 mt-2 font-medium">Item paling hits minggu ini yang wajib kamu punya.</p>
                </div>
                <a href="{{ route('workshop') }}" class="text-orange-600 font-bold hover:text-orange-700 flex items-center gap-1 group">
                    Lihat Semua <span class="group-hover:translate-x-1 transition">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <a href="{{ route('workshop') }}" class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition group border border-gray-100 hover:border-orange-200 cursor-pointer interactive-card">
                    <div class="aspect-square bg-orange-50 rounded-[1.5rem] flex items-center justify-center mb-4 relative overflow-hidden p-2">
                        <img src="{{ asset('picture/bonekaCoklat.png') }}" alt="Classic Choco" class="w-full h-full object-contain group-hover:scale-110 transition duration-500">
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">HOT</div>
                    </div>
                    <div class="px-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Classic Choco</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-3">Base Body</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-display font-extrabold text-orange-600">Rp 150rb</span>
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-orange-600 hover:text-white flex items-center justify-center transition font-bold text-lg">+</button>
                        </div>
                    </div>
                </a>

                <a href="{{ route('workshop') }}" class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition group border border-gray-100 hover:border-orange-200 cursor-pointer interactive-card">
                    <div class="aspect-square bg-blue-50 rounded-[1.5rem] flex items-center justify-center mb-4 relative overflow-hidden p-2">
                        <img src="{{ asset('picture/hoodie-biru.png') }}" alt="Hoodie Biru" class="w-full h-full object-contain group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="px-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Hoodie Biru</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-3">by Urban Style</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-display font-extrabold text-orange-600">Rp 75rb</span>
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-orange-600 hover:text-white flex items-center justify-center transition font-bold text-lg">+</button>
                        </div>
                    </div>
                </a>

                <a href="{{ route('workshop') }}" class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition group border border-gray-100 hover:border-orange-200 cursor-pointer interactive-card">
                    <div class="aspect-square bg-pink-50 rounded-[1.5rem] flex items-center justify-center mb-4 relative overflow-hidden p-2">
                        <img src="{{ asset('picture/dress-pink.png') }}" alt="Dress Pink" class="w-full h-full object-contain group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="px-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Dress Pink</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-3">by Cute Stuff</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-display font-extrabold text-orange-600">Rp 65rb</span>
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-orange-600 hover:text-white flex items-center justify-center transition font-bold text-lg">+</button>
                        </div>
                    </div>
                </a>

                <a href="{{ route('workshop') }}" class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition group border border-gray-100 hover:border-orange-200 cursor-pointer interactive-card">
                    <div class="aspect-square bg-green-50 rounded-[1.5rem] flex items-center justify-center mb-4 relative overflow-hidden p-4">
                        <img src="{{ asset('picture/kacamata.png') }}" alt="Kacamata" class="w-full h-full object-contain group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="px-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Kacamata</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase mb-3">by Retro Vibe</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-display font-extrabold text-orange-600">Rp 25rb</span>
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-orange-600 hover:text-white flex items-center justify-center transition font-bold text-lg">+</button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div id="reviews" class="bg-orange-600 py-20 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl font-display font-extrabold mb-16">Cerita Sahabat Teddy</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-orange-700/50 p-8 rounded-[2rem] relative hover:bg-orange-700 transition shadow-lg backdrop-blur-sm border border-orange-500/30 interactive-card">
                    <div class="text-6xl absolute -top-6 left-6 text-orange-300/20 font-serif">❝</div>
                    <p class="mb-6 italic text-orange-50 font-medium leading-relaxed">"Kualitas bonekanya premium banget! Lembut dan aman buat adikku. Pengiriman juga super cepat."</p>
                    <div class="flex items-center justify-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold shadow-md">A</div>
                        <div class="text-left">
                            <div class="font-bold text-white">Anya S.</div>
                            <div class="text-xs text-orange-200 font-bold">Jakarta</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white text-gray-800 p-10 rounded-[2.5rem] relative transform md:scale-110 shadow-2xl z-10 interactive-card">
                    <div class="text-6xl absolute -top-6 left-8 text-orange-200 font-serif">❝</div>
                    <p class="mb-6 italic font-medium leading-relaxed text-gray-600">"Fitur rekam suaranya keren parah! Jadi kado wisuda paling berkesan buat pacar. Makasih Build-A-Teddy!"</p>
                    <div class="flex items-center justify-center gap-4">
                        <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">B</div>
                        <div class="text-left">
                            <div class="font-bold text-gray-900">Budi Pratama</div>
                            <div class="text-xs text-orange-500 font-bold">Bandung</div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-center text-yellow-400 text-xl gap-1">★★★★★</div>
                </div>
                <div class="bg-orange-700/50 p-8 rounded-[2rem] relative hover:bg-orange-700 transition shadow-lg backdrop-blur-sm border border-orange-500/30 interactive-card">
                    <div class="text-6xl absolute -top-6 left-6 text-orange-300/20 font-serif">❝</div>
                    <p class="mb-6 italic text-orange-50 font-medium leading-relaxed">"Seneng banget bisa beli baju boneka dari desainer lokal. Modelnya lucu-lucu dan gak pasaran."</p>
                    <div class="flex items-center justify-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold shadow-md">C</div>
                        <div class="text-left">
                            <div class="font-bold text-white">Citra Kirana</div>
                            <div class="text-xs text-orange-200 font-bold">Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="sellers" class="py-20 px-4">
        <div class="max-w-7xl mx-auto bg-gray-900 rounded-[3rem] overflow-hidden relative shadow-2xl flex flex-col md:flex-row items-center group">
            <div class="md:w-1/2 p-12 md:p-16 relative z-10 text-white">
                <span class="text-orange-400 font-bold tracking-widest uppercase text-xs mb-3 block">Komunitas Kreator Indonesia</span>
                <h2 class="text-4xl md:text-5xl font-display font-extrabold mb-6 leading-tight">
                    Punya Hobi Jahit?<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500">Jadilah Seller!</span>
                </h2>
                <p class="text-gray-400 mb-8 text-lg font-medium leading-relaxed">
                    Gabung dengan ribuan kreator lain. Upload desain bajumu, kami sediakan bonekanya. Cuan ngalir dari rumah!
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('store.register') }}" class="bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-orange-700 transition shadow-lg transform hover:-translate-y-1 group-hover:shadow-orange-900/50">
                        Buka Toko Gratis
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 h-full relative flex items-center justify-center p-10 min-h-[300px]">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-purple-600/20"></div>
                <span class="text-9xl relative z-10 drop-shadow-2xl filter animate-bounce">🏪</span>
            </div>
        </div>
    </div>

    <div class="py-20 bg-white border-t border-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-display font-extrabold text-gray-900">Teddy Care Guide 🏥</h2>
                <p class="text-gray-500 mt-2 font-medium">Tips agar boneka kesayanganmu awet selamanya.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex gap-6 items-start bg-orange-50 p-8 rounded-[2rem] border border-orange-100 hover:shadow-lg transition cursor-default interactive-card">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl shadow-sm border border-orange-50 flex-shrink-0">🚿</div>
                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-2 font-display">Spa Day (Mencuci)</h4>
                        <p class="text-gray-600 text-sm leading-relaxed font-medium">
                            Gunakan air dingin dan deterjen bayi yang lembut. Cuci manual dengan tangan (jangan pakai mesin cuci) agar bulu tetap halus. Jangan diperas terlalu kuat ya!
                        </p>
                    </div>
                </div>
                <div class="flex gap-6 items-start bg-orange-50 p-8 rounded-[2rem] border border-orange-100 hover:shadow-lg transition cursor-default interactive-card">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl shadow-sm border border-orange-50 flex-shrink-0">🌞</div>
                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-2 font-display">Sunbathing (Menjemur)</h4>
                        <p class="text-gray-600 text-sm leading-relaxed font-medium">
                            Hindari menjemur di bawah sinar matahari langsung agar warna tidak pudar. Cukup diangin-anginkan di tempat teduh sampai kering sempurna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="track-order" class="py-20 bg-orange-50">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <span class="text-5xl mb-6 block animate-bounce">🚚</span>
            <h2 class="text-3xl font-display font-extrabold text-gray-900 mb-4">Lacak Paketmu</h2>
            <p class="text-gray-600 mb-10 font-medium">Masukkan nomor resi atau Order ID untuk melihat posisi Teddy-mu sekarang.</p>
            <form action="{{ route('history') }}" method="GET" class="bg-white p-2 rounded-full shadow-xl border border-orange-100 flex transition hover:shadow-2xl max-w-lg mx-auto">
                <input type="text" placeholder="Contoh: TRX-88291..." class="flex-1 px-8 py-4 rounded-l-full outline-none text-gray-700 font-bold placeholder-gray-300 bg-transparent">
                <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-full font-bold hover:bg-orange-700 transition shadow-md">
                    Cek Resi
                </button>
            </form>
            <div class="mt-8 flex justify-center gap-8 text-sm font-bold text-gray-400">
                <span class="flex items-center gap-2"><span class="text-green-500">✅</span> Real-time Update</span>
                <span class="flex items-center gap-2"><span class="text-blue-500">🛡️</span> Garansi Pengiriman</span>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t-4 border-orange-100 pt-20 pb-10 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-10 text-gray-800">
                
                <div class="col-span-2 md:col-span-2 space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="text-5xl filter drop-shadow-sm">🧸</span>
                        <h3 class="text-3xl font-display font-extrabold text-orange-600 tracking-wide leading-none">BUILD-A-TEDDY</h3>
                    </div>
                    <p class="text-sm text-gray-500 font-medium max-w-sm leading-relaxed">
                        Merek boneka kustomisasi premium, diciptakan untuk membawa senyuman di setiap pelukan.
                    </p>
                    
                    <div class="flex gap-4 pt-2 text-gray-400">
                        </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-bold text-gray-900 font-display mb-3">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('refund_policy') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">Pengembalian Dana</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">FAQ & Bantuan</a></li>
                        <li><a href="{{ route('policy') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-bold text-gray-900 font-display mb-3">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">Tentang Kami</a></li>                        <li><a href="{{ route('seller_policy') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">Kebijakan Seller</a></li>
                        <li><a href="{{ route('location') }}" class="text-gray-600 hover:text-orange-600 transition font-medium">Lokasi Store</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-bold text-gray-900 font-display mb-3">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm font-medium">
                        <li class="flex items-center gap-2 text-gray-600">
                            <span class="text-orange-500">📞</span> Telp: (0341) 577-911
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <span class="text-orange-500">📧</span> <a href="{{ route('contact') }}" class="hover:text-orange-600 transition">Email CS</a>
                        </li>
                        <li class="text-gray-600">
                            <p class="font-bold">Kantor Pusat:</p>
                            <p class="text-xs">Jl. Veteran, Lowokwaru,<br>Kota Malang, 65145</p>
                        </li>
                    </ul>
                </div>

            </div>
            
            <div class="border-t border-gray-200 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>
                    &copy; 2025 Build-A-Teddy Official Store. All Rights Reserved.
                </p>
                <p class="font-bold mt-3 md:mt-0">
                    Project by <span class="text-orange-600">Ossa & Shelfina</span> (PTI UB Malang)
                </p>
            </div>
        </div>
    </footer>

</body>
</html>