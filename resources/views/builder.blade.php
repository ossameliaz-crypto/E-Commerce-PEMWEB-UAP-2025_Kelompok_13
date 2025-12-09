<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token untuk keamanan kirim data via JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teddy Catalog - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        .pop-enter { animation: pop-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes pop-in { 0% { opacity: 0; transform: scale(0.5); } 100% { opacity: 1; transform: scale(1); } }
        
        .talking { animation: talk 0.5s infinite alternate; }
        @keyframes talk { 0% { transform: scale(1); } 100% { transform: scale(1.05); } }
        
        .recording-pulse { animation: pulse-red 1s infinite; }
        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); } 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); } }

        .scent-float { animation: float-up 2s infinite ease-in-out; }
        @keyframes float-up { 0% { transform: translateY(0) scale(1); opacity: 0.8; } 100% { transform: translateY(-20px) scale(1.2); opacity: 0; } }

        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.2); }
    </style>
</head>

<!-- X-DATA DITARUH DI BODY AGAR BISA DIAKSES GLOBAL -->
<body class="bg-gray-50 h-screen flex flex-col overflow-hidden"
      x-data="{ 
        // STATE PENCARIAN & KATEGORI
        search: '',
        category: 'body',
        
        // STATE UTAMA (SELECTED)
        selectedBase: 'coklat', selectedSize: 'M',
        selectedOutfit: 'none', selectedAccessory: 'none', selectedVoice: 'none', selectedScent: 'none',
        giftBox: 'none', cardMessage: '', dressBear: 'true',
        
        // STATE HOVER (PREVIEW)
        hoverBase: null, hoverOutfit: null, hoverAccessory: null,

        // DATABASE ITEM (LENGKAP)
        items: {
            bodies: [
                { id: 'coklat', name: 'Choco Bear', desc: 'Classic', color: '#8B4513' },
                { id: 'krem', name: 'Cream Bear', desc: 'Soft', color: '#F5DEB3' },
                { id: 'panda', name: 'Mr. Panda', desc: 'Rare', color: '#333', isPanda: true }
            ],
            outfits: [
                { id: 'none', name: 'Lepas Baju', icon: '❌', price: 0 },
                { id: 'kaos', name: 'Kaos Merah', icon: '👕', price: 50000, seller: 'Seller A', isHot: true },
                { id: 'hoodie', name: 'Hoodie Biru', icon: '🧥', price: 75000, seller: 'Seller B' },
                { id: 'dress', name: 'Dress Pink', icon: '👗', price: 65000, seller: 'Seller C' }
            ],
            accessories: [
                { id: 'none', name: 'Lepas Acc', icon: '❌', price: 0 },
                { id: 'kacamata', name: 'Kacamata', icon: '👓', price: 25000 },
                { id: 'topi', name: 'Topi Sulap', icon: '🎩', price: 35000 },
                { id: 'pita', name: 'Pita Lucu', icon: '🎀', price: 15000 }
            ],
            voices: [
                { id: 'none', name: 'Hening', icon: '🔇', price: 0 },
                { id: 'love', name: 'I Love You', icon: '❤️', price: 30000 },
                { id: 'bday', name: 'Birthday', icon: '🎂', price: 30000 }
            ],
            scents: [
                { id: 'none', name: 'Tanpa Aroma', icon: '👃', price: 0 },
                { id: 'vanilla', name: 'Vanilla', icon: '🍦', price: 15000 },
                { id: 'strawberry', name: 'Strawberry', icon: '🍓', price: 15000 },
                { id: 'chocolate', name: 'Coklat', icon: '🍫', price: 15000 },
                { id: 'bubblegum', name: 'Bubblegum', icon: '🍬', price: 20000 },
                { id: 'lavender', name: 'Lavender', icon: '🪻', price: 20000 }
            ],
            gifts: [
                { id: 'none', name: 'Standard Box', icon: '📦', price: 0, desc: 'Gratis' },
                { id: 'premium', name: 'Premium Gift', icon: '🎀', price: 25000, desc: 'Pita Cantik' },
                { id: 'birthday', name: 'Birthday Box', icon: '🎂', price: 30000, desc: 'Tema Ultah' }
            ]
        },

        // LOGIC FILTER
        filterItems(list) {
            if (this.search === '') return list;
            return list.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()));
        },

        // LOGIC TAMPILAN
        get activeBase() { return this.hoverBase ? this.hoverBase : this.selectedBase },
        get activeOutfit() { 
            if(this.dressBear === 'false' && !this.hoverOutfit) return 'none';
            return this.hoverOutfit ? this.hoverOutfit : this.selectedOutfit 
        },
        get activeAccessory() { return this.hoverAccessory ? this.hoverAccessory : this.selectedAccessory },

        // HARGA DINAMIS
        basePrices: { 'S': 100000, 'M': 150000, 'L': 250000 },
        get currentOutfitPrice() { return this.items.outfits.find(i => i.id === this.selectedOutfit)?.price || 0; },
        get currentAccPrice() { return this.items.accessories.find(i => i.id === this.selectedAccessory)?.price || 0; },
        get currentVoicePrice() { 
            if(this.selectedVoice === 'record') return 75000;
            return this.items.voices.find(i => i.id === this.selectedVoice)?.price || 0; 
        },
        get currentScentPrice() { return this.items.scents.find(i => i.id === this.selectedScent)?.price || 0; },
        get currentGiftPrice() { return this.items.gifts.find(i => i.id === this.giftBox)?.price || 0; },
        
        get totalPrice() { 
            return this.basePrices[this.selectedSize] + this.currentOutfitPrice + this.currentAccPrice + this.currentVoicePrice + this.currentScentPrice + this.currentGiftPrice;
        },

        // HELPER VISUAL
        get bearColor() { 
            let base = this.items.bodies.find(b => b.id === this.activeBase);
            return base ? base.color : '#8B4513';
        },
        get bearBellyColor() { return this.activeBase === 'coklat' ? '#D2691E' : (this.activeBase === 'krem' ? '#FFF8DC' : '#FFFFFF'); },
        get bearScale() { return this.selectedSize === 'S' ? 'scale(0.85)' : (this.selectedSize === 'M' ? 'scale(1)' : 'scale(1.15)'); },

        // LOGIC REKAM SUARA
        isRecording: false, audioBlob: null, audioUrl: null, mediaRecorder: null, audioChunks: [], isTalking: false,
        
        startRecording() {
            this.selectedVoice = 'record';
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];
                this.mediaRecorder.ondataavailable = (event) => { if (event.data.size > 0) this.audioChunks.push(event.data); };
                this.mediaRecorder.onstop = () => {
                    const mimeType = 'audio/webm';
                    this.audioBlob = new Blob(this.audioChunks, { type: mimeType });
                    this.audioUrl = URL.createObjectURL(this.audioBlob);
                    this.isRecording = false;
                    stream.getTracks().forEach(track => track.stop());
                };
                this.mediaRecorder.start(100); 
                this.isRecording = true;
            }).catch(error => { alert('Gagal akses mikrofon.'); });
        },

        stopRecording() { if(this.mediaRecorder && this.mediaRecorder.state !== 'inactive') this.mediaRecorder.stop(); },

        speak() {
            if (this.selectedVoice === 'record') {
                if (this.audioUrl) {
                    let audio = new Audio(this.audioUrl);
                    this.isTalking = true;
                    audio.play().catch(e => { console.error('Error play:', e); });
                    audio.onended = () => { this.isTalking = false; };
                } else { if(this.category === 'voice') alert('Rekam suara dulu ya sebelum diputar! 🎤'); }
                return;
            }
            if(this.selectedVoice === 'none') return;
            let text = this.selectedVoice === 'love' ? 'I love you so much!' : (this.selectedVoice === 'bday' ? 'Happy Birthday to You!' : 'Halo!');
            let u = new SpeechSynthesisUtterance(text);
            u.lang = 'id-ID'; u.pitch = 1.4;
            this.isTalking = true;
            window.speechSynthesis.speak(u);
            u.onend = () => this.isTalking = false;
        },

        // LOGIC SUBMIT FORM (CART / BUY)
        submitForm(type) {
            let form = this.$refs.formBuilder;
            let formData = new FormData(form);
            formData.append('action_type', type);

            if (this.selectedVoice === 'record' && this.audioBlob) {
                formData.append('audio_blob', this.audioBlob, 'voice_record.webm');
            }

            // Indikator Loading
            let btn = document.getElementById(type === 'buy' ? 'btn-buy' : 'btn-cart');
            let originalText = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url; 
                } else if (response.ok) {
                    // Fallback manual redirect jika backend tidak redirect
                    window.location.href = type === 'buy' ? '{{ route('checkout') }}' : '{{ route('wardrobe') }}';
                } else {
                    alert('Gagal menyimpan pesanan. Coba lagi.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            }).catch(err => {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
     }">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 h-16 flex items-center px-6 justify-between flex-none z-50">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <span class="text-3xl">🧸</span>
                <span class="font-extrabold text-gray-800 text-xl tracking-tight hidden md:block">Teddy Catalog</span>
            </a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <div class="flex gap-4 text-sm font-bold text-gray-500">
                <a href="{{ url('/') }}" class="hover:text-orange-600 transition">Home</a>
                <a href="{{ route('wardrobe') }}" class="hover:text-orange-600 transition">Inventory</a>
            </div>
        </div>
        
        <!-- SEARCH BAR -->
        <div class="hidden md:flex flex-1 max-w-lg mx-8 relative">
            <input type="text" x-model="search" placeholder="Cari baju, topi, aroma..." class="w-full bg-gray-100 border-none rounded-full py-2 px-6 focus:ring-2 focus:ring-orange-500 outline-none text-sm font-bold transition shadow-inner">
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-500 text-white p-1.5 rounded-full hover:bg-orange-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>

        <div class="flex items-center gap-4" x-data="{ openProfile: false }">
            <!-- Cart Icon -->
            <a href="{{ route('wardrobe') }}" class="relative group p-2 hover:bg-gray-100 rounded-full transition mr-1">
                <svg class="w-6 h-6 text-gray-600 group-hover:text-orange-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full font-bold">0</span>
            </a>

            <!-- PROFILE DROPDOWN (FITUR BARU) -->
            <div class="relative">
                <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-2 focus:outline-none group">
                    <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold border-2 border-white shadow-sm group-hover:ring-2 group-hover:ring-orange-200 transition overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::check() ? Auth::user()->name : 'Guest' }}&background=ffedd5&color=ea580c" alt="Profile" class="w-full h-full object-cover">
                    </div>
                    <div class="hidden md:block text-left leading-tight">
                        <p class="text-xs font-bold text-gray-700 truncate w-20">{{ Auth::check() ? Auth::user()->name : 'Tamu' }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">{{ Auth::check() ? Auth::user()->role : 'Visitor' }}</p>
                    </div>
                    <svg class="w-3 h-3 text-gray-400 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="openProfile" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" 
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    
                    @auth
                        <div class="px-4 py-3 border-b border-gray-50 mb-1">
                            <p class="text-sm font-extrabold text-gray-800">Halo, {{ Auth::user()->name }}!</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition"><span>👤</span> Akun Saya</a>
                        <a href="{{ route('history') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition"><span>📦</span> Pesanan Saya</a>
                        
                        @if(Auth::user()->role === 'seller')
                             <div class="border-t border-gray-50 my-1"></div>
                             <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-green-600 hover:bg-green-50 font-bold transition"><span>🏪</span> Toko Saya</a>
                        @endif

                        <div class="border-t border-gray-50 mt-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition"><span>🚪</span> Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">🔐 Masuk</a>
                        <a href="{{ route('register') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">✨ Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN APP -->
    <div class="flex-1 flex overflow-hidden">

        <!-- SIDEBAR KIRI (Menu Kategori) -->
        <aside class="w-20 bg-white border-r border-gray-200 flex flex-col items-center py-6 gap-4 z-10 shadow-sm">
            <button @click="category = 'body'; search = ''" :class="category === 'body' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">🐻</button>
            <button @click="category = 'clothing'; search = ''" :class="category === 'clothing' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">👕</button>
            <button @click="category = 'accessories'; search = ''" :class="category === 'accessories' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">👓</button>
            <button @click="category = 'voice'; search = ''" :class="category === 'voice' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">🎤</button>
            <button @click="category = 'scent'; search = ''" :class="category === 'scent' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">🌸</button>
            <button @click="category = 'gift'; search = ''" :class="category === 'gift' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl transition group relative">🎁</button>
        </aside>

        <!-- AREA TENGAH (KATALOG DINAMIS) -->
        <main class="flex-1 bg-gray-50 p-6 overflow-y-auto hide-scroll">
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800" x-text="search ? 'Hasil Pencarian: ' + search : (category === 'body' ? 'Pilih Karakter' : 'Katalog Item')"></h2>
                    <p class="text-sm text-gray-500">Klik item untuk memilih.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                <!-- 1. BODY -->
                <template x-if="category === 'body' || (search && category === 'body')">
                    <div class="contents">
                        <div class="col-span-full bg-orange-100 p-4 rounded-xl flex gap-4 items-center mb-2" x-show="!search">
                            <span class="font-bold text-orange-800 text-sm">Ukuran:</span>
                            <button @click="selectedSize = 'S'" :class="selectedSize === 'S' ? 'bg-white text-orange-600 shadow' : 'text-orange-400 hover:bg-white/50'" class="px-4 py-1 rounded-lg font-bold text-xs transition">Small</button>
                            <button @click="selectedSize = 'M'" :class="selectedSize === 'M' ? 'bg-white text-orange-600 shadow' : 'text-orange-400 hover:bg-white/50'" class="px-4 py-1 rounded-lg font-bold text-xs transition">Medium</button>
                            <button @click="selectedSize = 'L'" :class="selectedSize === 'L' ? 'bg-white text-orange-600 shadow' : 'text-orange-400 hover:bg-white/50'" class="px-4 py-1 rounded-lg font-bold text-xs transition">Jumbo</button>
                        </div>
                        <template x-for="item in filterItems(items.bodies)" :key="item.id">
                            <div @click="selectedBase = item.id" @mouseenter="hoverBase = item.id" @mouseleave="hoverBase = null" :class="selectedBase === item.id ? 'ring-2 ring-blue-500 bg-white' : 'bg-white'" class="border p-3 rounded-xl cursor-pointer hover-card transition">
                                <div class="w-16 h-16 rounded-full mx-auto mb-2 shadow-sm" :style="'background-color: ' + item.color"></div>
                                <h4 class="font-bold text-center text-sm text-gray-800" x-text="item.name"></h4>
                                <p class="text-xs text-gray-400 text-center" x-text="item.desc"></p>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- 2. CLOTHING -->
                <template x-if="category === 'clothing'">
                    <template x-for="item in filterItems(items.outfits)" :key="item.id">
                        <div @click="selectedOutfit = item.id" @mouseenter="hoverOutfit = item.id" @mouseleave="hoverOutfit = null" 
                             :class="selectedOutfit === item.id ? 'ring-2 ring-blue-500 bg-white' : 'bg-white'" 
                             class="border p-3 rounded-xl cursor-pointer hover-card transition relative">
                             <div x-show="item.isHot" class="absolute top-2 right-2 bg-yellow-400 text-[10px] px-1.5 rounded font-bold">Hot</div>
                            <div class="aspect-square bg-gray-50 rounded-lg mb-2 flex items-center justify-center text-4xl" x-text="item.icon"></div>
                            <h4 class="font-bold text-sm text-gray-700 truncate" x-text="item.name"></h4>
                            <div class="flex justify-between items-center mt-1" x-show="item.price > 0"><span class="text-xs font-bold text-green-600" x-text="'Rp ' + (item.price/1000) + 'k'"></span><span class="text-[10px] text-gray-400" x-text="item.seller"></span></div>
                            <span class="text-xs font-bold text-gray-400 block mt-1" x-show="item.price === 0">Gratis</span>
                        </div>
                    </template>
                </template>

                <!-- 3. ACCESSORIES -->
                <template x-if="category === 'accessories'">
                    <template x-for="item in filterItems(items.accessories)" :key="item.id">
                        <div @click="selectedAccessory = item.id" @mouseenter="hoverAccessory = item.id" @mouseleave="hoverAccessory = null" :class="selectedAccessory === item.id ? 'ring-2 ring-blue-500 bg-white' : 'bg-white'" class="border p-3 rounded-xl cursor-pointer hover-card transition"><div class="aspect-square bg-gray-50 rounded-lg mb-2 flex items-center justify-center text-4xl" x-text="item.icon"></div><h4 class="font-bold text-sm text-gray-700 truncate" x-text="item.name"></h4><span class="text-xs font-bold text-green-600 block mt-1" x-show="item.price > 0" x-text="'Rp ' + (item.price/1000) + 'k'"></span><span class="text-xs font-bold text-gray-400 block mt-1" x-show="item.price === 0">Gratis</span></div>
                    </template>
                </template>

                <!-- 4. VOICE -->
                <template x-if="category === 'voice'">
                    <div class="contents">
                        <template x-for="item in filterItems(items.voices)" :key="item.id">
                            <div @click="selectedVoice = item.id; item.id !== 'none' ? speak() : null" :class="selectedVoice === item.id ? 'ring-2 ring-blue-500 bg-white' : 'bg-white'" class="border p-4 rounded-xl text-center cursor-pointer hover-card transition">
                                <div class="text-4xl mb-2" x-text="item.icon"></div>
                                <h4 class="font-bold text-sm text-gray-700" x-text="item.name"></h4>
                                <span class="text-xs font-bold text-green-600" x-show="item.price > 0" x-text="'Rp ' + (item.price/1000) + 'k'"></span>
                            </div>
                        </template>
                        <div x-show="search === '' || 'rekam'.includes(search.toLowerCase())" @click="selectedVoice = 'record'" :class="selectedVoice === 'record' ? 'ring-4 ring-red-500 bg-red-50' : 'bg-white'" class="col-span-2 border-2 border-dashed border-red-300 p-4 rounded-2xl cursor-pointer relative overflow-hidden group hover:border-red-500 transition">
                            <div class="flex items-center justify-between mb-4"><div class="flex items-center gap-2 text-red-600 font-bold"><span class="text-2xl">🎙️</span> Rekam Sendiri</div><span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded font-bold">+75rb</span></div>
                            <div class="flex justify-center gap-3">
                                <button @click.stop="startRecording()" x-show="!isRecording && !audioUrl" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-bold shadow-lg flex items-center gap-2 transform hover:scale-105 transition"><span>🔴</span> Rec</button>
                                <button @click.stop="stopRecording()" x-show="isRecording" class="bg-gray-800 text-white px-6 py-2 rounded-full font-bold animate-pulse shadow-lg"><span>⏹️</span> Stop</button>
                                <div x-show="audioUrl" class="flex gap-2 w-full"><button @click.stop="speak()" class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-bold">▶ Play</button><button @click.stop="audioUrl = null" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold">Reset</button></div>
                            </div>
                            <p class="text-center text-xs text-gray-400 mt-2" x-show="!isRecording && !audioUrl">Klik tombol merah untuk mulai merekam.</p>
                        </div>
                    </div>
                </template>

                <!-- 5. SCENT -->
                <template x-if="category === 'scent'">
                    <template x-for="item in filterItems(items.scents)" :key="item.id">
                        <div @click="selectedScent = item.id" :class="selectedScent === item.id ? 'ring-2 ring-blue-500 bg-white' : 'bg-white'" class="border p-4 rounded-xl text-center cursor-pointer hover-card transition"><div class="text-4xl mb-2" x-text="item.icon"></div><h4 class="font-bold text-sm text-gray-700" x-text="item.name"></h4><span class="text-xs font-bold text-green-600" x-show="item.price > 0" x-text="'Rp ' + (item.price/1000) + 'k'"></span></div>
                    </template>
                </template>

                <!-- 6. GIFT -->
                <template x-if="category === 'gift'">
                    <div class="col-span-full space-y-6">
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm"><h3 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2"><span class="text-2xl">🎁</span> Pilih Kemasan</h3><div class="grid grid-cols-1 md:grid-cols-3 gap-4"><template x-for="item in items.gifts" :key="item.id"><div @click="giftBox = item.id" :class="giftBox === item.id ? 'ring-2 ring-orange-500 bg-orange-50' : 'border border-gray-200'" class="p-4 rounded-xl cursor-pointer text-center hover:shadow-md transition"><div class="text-4xl mb-2" x-text="item.icon"></div><h4 class="font-bold text-sm" x-text="item.name"></h4><p class="text-xs text-orange-600 font-bold" x-text="item.price === 0 ? 'Gratis' : '+Rp ' + (item.price/1000) + 'k'"></p></div></template></div></div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm" x-show="giftBox !== 'none'" x-transition><h3 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2"><span class="text-2xl">💌</span> Kartu Ucapan</h3><textarea x-model="cardMessage" class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-orange-500 outline-none font-sans text-sm" rows="3" placeholder="Tulis pesan spesialmu di sini..."></textarea></div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm"><h3 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2"><span class="text-2xl">🧸</span> Kondisi Boneka</h3><div class="flex gap-4"><label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer w-full hover:bg-gray-50" :class="dressBear === 'true' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'"><input type="radio" name="dress_option" value="true" x-model="dressBear" class="text-orange-600 focus:ring-orange-500 h-5 w-5"><div><span class="font-bold text-sm block">Dipakaikan Baju</span><span class="text-xs text-gray-500">Siap dipeluk.</span></div></label><label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer w-full hover:bg-gray-50" :class="dressBear === 'false' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'"><input type="radio" name="dress_option" value="false" x-model="dressBear" class="text-orange-600 focus:ring-orange-500 h-5 w-5"><div><span class="font-bold text-sm block">Bungkus Terpisah</span><span class="text-xs text-gray-500">Unboxing experience.</span></div></label></div></div>
                    </div>
                </template>

            </div>
        </main>

        <!-- SIDEBAR KANAN: PREVIEW & CHECKOUT -->
        <aside class="w-80 bg-white border-l border-gray-200 flex flex-col z-20 shadow-xl">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-extrabold text-gray-800">Preview</h3>
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded font-bold" x-text="selectedSize === 'S' ? 'Small' : (selectedSize === 'M' ? 'Medium' : 'Jumbo')"></span>
            </div>

            <div class="flex-1 bg-orange-50/50 flex items-center justify-center relative overflow-hidden" @click="speak()">
                <div x-show="hoverOutfit || hoverAccessory || hoverBase" x-transition class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white text-xs px-3 py-1 rounded-full font-bold z-50 pointer-events-none">👀 Previewing...</div>
                <div x-show="selectedVoice !== 'none'" class="absolute top-4 right-4 text-2xl animate-pulse z-50">🔊</div>
                <div x-show="selectedScent !== 'none'" class="absolute top-20 right-10 text-3xl z-40 scent-float" x-text="selectedScent === 'vanilla' ? '🍦' : (selectedScent === 'strawberry' ? '🍓' : (selectedScent === 'chocolate' ? '🍫' : (selectedScent === 'bubblegum' ? '🍬' : '🪻')))"></div>
                <div x-show="giftBox !== 'none'" class="absolute bottom-4 right-4 text-4xl z-50 animate-bounce" x-transition><span x-text="giftBox === 'premium' ? '🎀' : (giftBox === 'birthday' ? '🎂' : '')"></span></div>

                <div :class="isTalking ? 'talking' : ''" class="transition-transform duration-500" :style="'transform: ' + bearScale">
                    <svg width="200" height="250" viewBox="0 0 200 250" class="drop-shadow-xl relative z-10">
                        <circle cx="40" cy="50" r="25" :fill="bearColor" /><circle cx="40" cy="50" r="12" :fill="bearBellyColor" />
                        <circle cx="160" cy="50" r="25" :fill="bearColor" /><circle cx="160" cy="50" r="12" :fill="bearBellyColor" />
                        <ellipse cx="30" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(-20 30 140)" />
                        <ellipse cx="170" cy="140" rx="25" ry="40" :fill="bearColor" transform="rotate(20 170 140)" />
                        <ellipse cx="60" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="60" cy="230" r="12" :fill="bearBellyColor" />
                        <ellipse cx="140" cy="220" rx="30" ry="40" :fill="bearColor" /><circle cx="140" cy="230" r="12" :fill="bearBellyColor" />
                        <ellipse cx="100" cy="160" rx="65" ry="75" :fill="bearColor" /><ellipse cx="100" cy="160" rx="40" ry="50" :fill="bearBellyColor" />
                        <circle cx="100" cy="80" r="60" :fill="bearColor" /><ellipse cx="100" cy="90" rx="25" ry="20" :fill="bearBellyColor" />
                        <circle cx="90" cy="80" r="5" fill="#000" /><circle cx="110" cy="80" r="5" fill="#000" />
                        <path d="M 95 95 Q 100 100 105 95" stroke="#3E2723" stroke-width="2" fill="none" />
                    </svg>
                    <!-- LAYERS (Active) -->
                    <div x-show="activeOutfit === 'kaos'" class="absolute z-20 top-[110px] left-0 right-0 flex justify-center pop-enter"><svg width="140" height="100" viewBox="0 0 140 100"><path d="M 40 10 L 100 10 L 120 40 L 100 50 L 90 30 L 90 90 L 50 90 L 50 30 L 40 50 L 20 40 Z" fill="#EF4444" stroke="#B91C1C" stroke-width="2"/><text x="70" y="60" font-size="20" text-anchor="middle" fill="white" font-weight="bold">UAP</text></svg></div>
                    <div x-show="activeOutfit === 'hoodie'" class="absolute z-20 top-[105px] left-0 right-0 flex justify-center pop-enter"><svg width="150" height="110" viewBox="0 0 150 110"><path d="M 45 5 L 105 5 L 130 40 L 110 55 L 100 35 L 100 100 L 50 100 L 50 35 L 40 55 L 20 40 Z" fill="#3B82F6" stroke="#1D4ED8" stroke-width="2"/><rect x="65" y="60" width="20" height="25" fill="#2563EB" rx="5" /></svg></div>
                    <div x-show="activeOutfit === 'dress'" class="absolute z-20 top-[110px] left-0 right-0 flex justify-center pop-enter"><svg width="140" height="120" viewBox="0 0 140 120"><path d="M 50 10 L 90 10 L 110 90 L 30 90 Z" fill="#EC4899" /><path d="M 30 90 Q 70 110 110 90" fill="#EC4899" /></svg></div>
                    <div x-show="activeAccessory === 'kacamata'" class="absolute z-30 top-[65px] left-0 right-0 flex justify-center pop-enter"><svg width="80" height="30" viewBox="0 0 80 30"><circle cx="20" cy="15" r="12" fill="#000" opacity="0.8" /><circle cx="60" cy="15" r="12" fill="#000" opacity="0.8" /><line x1="32" y1="15" x2="48" y2="15" stroke="#000" stroke-width="2" /></svg></div>
                    <div x-show="activeAccessory === 'topi'" class="absolute z-30 top-[-10px] left-0 right-0 flex justify-center pop-enter"><svg width="100" height="80" viewBox="0 0 100 80"><rect x="25" y="20" width="50" height="50" fill="#1F2937" /><rect x="10" y="65" width="80" height="10" fill="#1F2937" /><rect x="25" y="55" width="50" height="5" fill="#EF4444" /></svg></div>
                    <div x-show="activeAccessory === 'pita'" class="absolute z-30 top-[15px] right-[45px]"><svg width="50" height="40" viewBox="0 0 50 40"><path d="M 25 20 L 5 5 L 5 35 Z" fill="#EC4899" /><path d="M 25 20 L 45 5 L 45 35 Z" fill="#EC4899" /><circle cx="25" cy="20" r="5" fill="#BE185D" /></svg></div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 bg-white">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-bold text-gray-500">Total</span>
                    <span class="text-2xl font-extrabold text-orange-600" x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
                </div>
                <form x-ref="formBuilder" action="{{ route('cart.add-custom') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="hidden" name="base" :value="selectedBase">
                    <input type="hidden" name="size" :value="selectedSize">
                    <input type="hidden" name="outfit" :value="selectedOutfit">
                    <input type="hidden" name="accessory" :value="selectedAccessory">
                    <input type="hidden" name="voice" :value="selectedVoice">
                    <input type="hidden" name="scent" :value="selectedScent">
                    <input type="hidden" name="gift_box" :value="giftBox">
                    <input type="hidden" name="card_message" :value="cardMessage">
                    <input type="hidden" name="dress_bear" :value="dressBear">
                    
                    <!-- TOMBOL MASUK KERANJANG -->
                    <button id="btn-cart" type="button" @click="submitForm('cart')" class="w-full bg-white border-2 border-orange-500 text-orange-600 font-bold py-3 rounded-xl hover:bg-orange-50 transition flex items-center justify-center gap-2 mb-3">
                        <span>👜</span> Masukkan Keranjang
                    </button>

                    <!-- TOMBOL BELI SEKARANG -->
                    <button id="btn-buy" type="button" @click="submitForm('buy')" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>🛒</span> Beli Sekarang
                    </button>
                </form>
            </div>
        </aside>

    </div>
</body>
</html>