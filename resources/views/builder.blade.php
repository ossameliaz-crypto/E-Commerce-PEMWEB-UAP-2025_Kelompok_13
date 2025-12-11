<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teddy Catalog - Final PNG Fixed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        .product-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15); }
        
        .recording-pulse { animation: pulse-red 1.5s infinite; }
        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); } 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); } }
    </style>
</head>

<body class="bg-gray-50 h-screen flex flex-col overflow-hidden"
      x-data="{ 
        // === STATE ===
        search: '', category: 'body',
        selectedBase: 'coklat', selectedSize: 'M',
        selectedOutfit: 'none', selectedAccessory: 'none', 
        selectedVoice: 'none', selectedScent: 'none',
        giftBox: 'none', cardMessage: '', dressBear: 'true',
        
        hoverBase: null, hoverOutfit: null, hoverAccessory: null,
        actionType: 'cart',

        // === HEADER JUDUL ===
        get headerTitle() {
            const titles = { 'body': 'Pilih Karakter', 'clothing': 'Creator Marketplace', 'accessories': 'Pilih Aksesoris', 'voice': 'Pilih Suara', 'scent': 'Pilih Aroma', 'gift': 'Packing & Kartu' };
            return titles[this.category] || 'Pilih Item';
        },

        // === DATABASE ITEMS (SEMUA PNG) ===
        items: {
            // 1. BODIES (10 ITEM - PNG)
            bodies: [
                { id: 'coklat', name: 'Choco Bear', price: 150000, image: `{{ asset('picture/bonekaCoklat.png') }}` },
                { id: 'krem', name: 'Cream Bear', price: 150000, image: `{{ asset('picture/bonekaCream.png') }}` },
                { id: 'polar', name: 'Polar Bear', price: 155000, image: `{{ asset('picture/polarBear.png') }}` },
                { id: 'panda', name: 'Mr. Panda', price: 160000, image: `{{ asset('picture/panda.png') }}` },
                { id: 'pink', name: 'Pinky Bear', price: 150000, image: `{{ asset('picture/bearPink.png') }}` },
                { id: 'deer', name: 'Grey Deer', price: 175000, image: `{{ asset('picture/greyDeer.png') }}` },
                { id: 'kitty', name: 'Hello Kitty', price: 200000, image: `{{ asset('picture/helloKitty.png') }}` },
                { id: 'bluey', name: 'Bluey', price: 180000, image: `{{ asset('picture/bluey.png') }}` },
                { id: 'bunny', name: 'Purple Bunny', price: 165000, image: `{{ asset('picture/purpleBunny.png') }}` },
                { id: 'cinamon', name: 'Green Cinnamon', price: 185000, image: `{{ asset('picture/greenCinamon.png') }}` }
            ],

            // 2. OUTFITS (PNG - Chef diganti Denim)
            outfits: [
                { id: 'none', name: 'Lepas Baju', price: 0, image: '', creator: '-' },
                { 
                    id: 'tuxedo', name: 'Tuxedo Hitam', price: 95000, 
                    creator: 'MrFormal', 
                    image: `{{ asset('picture/tuxedo.png') }}`, 
                    image_worn: `{{ asset('picture/tuxedo-worn.png') }}` 
                },
                { 
                    id: 'kaos', name: 'Kaos Merah', price: 50000, 
                    creator: 'SimpleStyle', 
                    image: `{{ asset('picture/kaos-merah.png') }}`, 
                    image_worn: `{{ asset('picture/kaos-merah-worn.png') }}` 
                },
                { 
                    id: 'hoodie', name: 'Hoodie Biru', price: 75000, 
                    creator: 'StreetWear', 
                    image: `{{ asset('picture/hoodie-biru.png') }}`, 
                    image_worn: `{{ asset('picture/hoodie-biru-worn.png') }}` 
                },
                { 
                    id: 'dress', name: 'Dress Pink', price: 65000, 
                    creator: 'Princess', 
                    image: `{{ asset('picture/dress-pink.png') }}`, 
                    image_worn: `{{ asset('picture/dress-pink-worn.png') }}` 
                },
                { 
                    id: 'piyama', name: 'Piyama Tidur', price: 55000, 
                    creator: 'Sleepy', 
                    image: `{{ asset('picture/piyama.png') }}`, 
                    image_worn: `{{ asset('picture/piyama-worn.png') }}` 
                },
                // GANTI CHEF -> JAKET DENIM (PNG)
                { 
                    id: 'denim', name: 'Jaket Denim', price: 85000, 
                    creator: 'DenimStyle', 
                    image: `{{ asset('picture/jaket-denim.png') }}`, 
                    image_worn: `{{ asset('picture/jaket-denim-worn.png') }}` 
                },
                { 
                    id: 'polisi', name: 'Seragam Polisi', price: 80000, 
                    creator: 'Police', 
                    image: `{{ asset('picture/polisi.png') }}`, 
                    image_worn: `{{ asset('picture/polisi-worn.png') }}` 
                },
                { 
                    id: 'dokter', name: 'Jas Dokter', price: 75000, 
                    creator: 'Medic', 
                    image: `{{ asset('picture/dokter.png') }}`, 
                    image_worn: `{{ asset('picture/dokter-worn.png') }}` 
                },
                { 
                    id: 'astronaut', name: 'Astronaut', price: 120000, 
                    creator: 'NASA', 
                    image: `{{ asset('picture/astronaut.png') }}`, 
                    image_worn: `{{ asset('picture/astronaut-worn.png') }}` 
                }
            ],

            // 3. ACCESSORIES (PNG)
            accessories: [
                { id: 'none', name: 'Lepas Acc', price: 0, image: '', creator: '-' },
                { id: 'kacamata', name: 'Kacamata', price: 25000, creator: 'SunGlasses', image: `{{ asset('picture/kacamata.png') }}` },
                { id: 'topi', name: 'Topi Sulap', price: 35000, creator: 'Magic', image: `{{ asset('picture/topi.png') }}` },
                { id: 'pita', name: 'Pita Lucu', price: 15000, creator: 'Cute', image: `{{ asset('picture/pita.png') }}` },
                { id: 'mahkota', name: 'Mahkota', price: 45000, creator: 'Royal', image: `{{ asset('picture/mahkota.png') }}` },
                { id: 'headphone', name: 'Headphone', price: 40000, creator: 'Tech', image: `{{ asset('picture/headphone.png') }}` },
                { id: 'tas', name: 'Tas Ransel', price: 30000, creator: 'Adventure', image: `{{ asset('picture/tas.png') }}` },
                { id: 'syal', name: 'Syal', price: 20000, creator: 'Winter', image: `{{ asset('picture/syal.png') }}` },
                { id: 'bunga', name: 'Bunga', price: 15000, creator: 'Florist', image: `{{ asset('picture/bunga.png') }}` },
                { id: 'masker', name: 'Masker', price: 10000, creator: 'Health', image: `{{ asset('picture/masker.png') }}` }
            ],

            // 4. VOICES
            voices: [
                { id: 'none', name: 'Hening', icon: '🔇', price: 0 },
                { id: 'love', name: 'I Love You', icon: '❤️', price: 30000 },
                { id: 'bday', name: 'Birthday', icon: '🎂', price: 30000 },
                { id: 'laugh', name: 'Ketawa', icon: '😂', price: 25000 },
                { id: 'lullaby', name: 'Lagu Tidur', icon: '🌙', price: 35000 },
                { id: 'congrats', name: 'Selamat', icon: '🎉', price: 30000 },
                { id: 'gws', name: 'GWS', icon: '💊', price: 30000 },
                { id: 'morning', name: 'Alarm', icon: '⏰', price: 25000 },
                { id: 'animal', name: 'Meow', icon: '🐱', price: 25000 },
                { id: 'sorry', name: 'Maaf', icon: '🙏', price: 30000 }
            ],

            // 5. SCENTS
            scents: [
                { id: 'none', name: 'Tanpa Aroma', icon: '👃', price: 0 },
                { id: 'vanilla', name: 'Vanilla', icon: '🍦', price: 15000 },
                { id: 'strawberry', name: 'Strawberry', icon: '🍓', price: 15000 },
                { id: 'chocolate', name: 'Coklat', icon: '🍫', price: 15000 },
                { id: 'bubblegum', name: 'Bubblegum', icon: '🍬', price: 20000 },
                { id: 'lavender', name: 'Lavender', icon: '🪻', price: 20000 },
                { id: 'coffee', name: 'Kopi', icon: '☕', price: 15000 },
                { id: 'rose', name: 'Mawar', icon: '🌹', price: 20000 },
                { id: 'lemon', name: 'Lemon', icon: '🍋', price: 15000 },
                { id: 'baby', name: 'Baby Powder', icon: '👶', price: 20000 }
            ],

            // 6. GIFTS
            gifts: [
                { id: 'none', name: 'Standard Box', icon: '📦', price: 0 },
                { id: 'premium', name: 'Premium Gift', icon: '🎀', price: 25000 },
                { id: 'birthday', name: 'Birthday Box', icon: '🎂', price: 30000 },
                { id: 'love', name: 'Valentine', icon: '💘', price: 35000 },
                { id: 'christmas', name: 'Xmas', icon: '🎄', price: 35000 },
                { id: 'lebaran', name: 'Eid', icon: '🕌', price: 30000 },
                { id: 'graduation', name: 'Wisuda', icon: '🎓', price: 30000 },
                { id: 'mystery', name: 'Mystery', icon: '❓', price: 50000 },
                { id: 'transparent', name: 'Clear Case', icon: '💎', price: 60000 },
                { id: 'basket', name: 'Piknik', icon: '🧺', price: 45000 }
            ]
        },

        // === LOGIC ===
        filterItems(list) { return this.search === '' ? list : list.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase())); },
        get activeBase() { return this.hoverBase ? this.hoverBase : this.selectedBase },
        get currentImage() { let item = this.items.bodies.find(i => i.id === this.activeBase); return item ? item.image : ''; },
        
        get totalPrice() { 
            let base = this.items.bodies.find(i => i.id === this.selectedBase)?.price || 0;
            let outfit = this.items.outfits.find(i => i.id === this.selectedOutfit)?.price || 0;
            let acc = this.items.accessories.find(i => i.id === this.selectedAccessory)?.price || 0;
            let voice = (this.selectedVoice === 'record') ? 75000 : (this.items.voices.find(i => i.id === this.selectedVoice)?.price || 0);
            let scent = this.items.scents.find(i => i.id === this.selectedScent)?.price || 0;
            let gift = this.items.gifts.find(i => i.id === this.giftBox)?.price || 0;
            return base + outfit + acc + voice + scent + gift;
        },

        // REKAM SUARA
        isRecording: false, audioBlob: null, audioUrl: null, mediaRecorder: null, audioChunks: [], isTalking: false,
        startRecording() {
            this.selectedVoice = 'record'; 
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];
                this.mediaRecorder.ondataavailable = (event) => { if (event.data.size > 0) this.audioChunks.push(event.data); };
                this.mediaRecorder.onstop = () => {
                    this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
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
                    audio.play();
                    audio.onended = () => { this.isTalking = false; };
                } else { alert('Rekam suara dulu!'); }
                return;
            }
            if(this.selectedVoice === 'none') return;
            let text = 'Halo!';
            let u = new SpeechSynthesisUtterance(text);
            u.lang = 'id-ID'; 
            this.isTalking = true;
            window.speechSynthesis.speak(u);
            u.onend = () => this.isTalking = false;
        },

        // SUBMIT
        submitForm(type) { 
            this.actionType = type;
            this.$nextTick(() => { this.$refs.formBuilder.submit(); });
        }
     }">

    <nav class="bg-white border-b border-gray-200 h-16 flex items-center px-6 justify-between flex-none z-50 sticky top-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-3xl">🧸</span>
                <span class="font-extrabold text-gray-800 text-xl tracking-tight hidden md:block">Teddy Catalog</span>
            </a>
        </div>
        <div class="hidden md:flex flex-1 max-w-lg mx-8 relative">
            <input type="text" x-model="search" placeholder="Cari..." class="w-full bg-gray-100 border-none rounded-full py-2 px-6 focus:ring-2 focus:ring-orange-500 outline-none text-sm font-bold">
        </div>
        <div class="flex items-center gap-4" x-data="{ openProfile: false }">
            <div class="relative">
                <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-2 focus:outline-none">
                    <div class="w-9 h-9 bg-orange-100 rounded-full border-2 border-white shadow-sm overflow-hidden flex items-center justify-center font-bold text-orange-600">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </button>
                <div x-show="openProfile" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-1 flex overflow-hidden">
        
        <aside class="w-20 bg-white border-r border-gray-200 flex flex-col items-center py-6 gap-4 z-10 shadow-sm overflow-y-auto hide-scroll">
            <button @click="category = 'body'" :class="category === 'body' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">🐻</button>
            <button @click="category = 'clothing'" :class="category === 'clothing' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">👕</button>
            <button @click="category = 'accessories'" :class="category === 'accessories' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">👓</button>
            <button @click="category = 'voice'" :class="category === 'voice' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">🎤</button>
            <button @click="category = 'scent'" :class="category === 'scent' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">🌸</button>
            <button @click="category = 'gift'" :class="category === 'gift' ? 'bg-orange-100 text-orange-600 ring-2 ring-orange-500' : 'text-gray-400 hover:bg-gray-100'" class="w-12 h-12 rounded-xl text-2xl transition">🎁</button>
        </aside>

        <main class="flex-1 bg-white p-8 overflow-y-auto hide-scroll">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800" x-text="headerTitle"></h2>
                <p class="text-gray-500">Sesuaikan boneka impianmu dengan item dari kreator.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 pb-20">
                
                <template x-if="category === 'body'">
                    <template x-for="item in filterItems(items.bodies)" :key="item.id">
                        <div class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-4 h-full group cursor-pointer"
                             @click="selectedBase = item.id">
                            <div class="aspect-square w-full mb-4 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden relative">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-contain transform group-hover:scale-105 transition" onerror="this.src='https://placehold.co/400?text=Gambar+Rusak';">
                            </div>
                            <div class="flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mb-2" x-text="item.name"></h3>
                                <div class="mt-auto w-full">
                                    <p class="text-xl font-extrabold text-orange-600 mb-4" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    <button :class="selectedBase === item.id ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-600 hover:bg-orange-50'" class="w-full py-3 rounded-md border-2 font-bold text-sm transition uppercase">
                                        <span x-text="selectedBase === item.id ? 'Selected' : 'Select'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="category === 'clothing'">
                    <template x-for="item in filterItems(items.outfits)" :key="item.id">
                        <div class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-4 h-full group cursor-pointer"
                             @click="selectedOutfit = item.id">
                            <div class="aspect-square w-full mb-4 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden relative">
                                <template x-if="item.id === 'none'"><span class="text-6xl text-gray-300">❌</span></template>
                                <template x-if="item.id !== 'none'">
                                    <img :src="item.image_worn ? item.image_worn : item.image" class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 opacity-0 group-hover:opacity-100" onerror="this.style.display='none'">
                                    <img :src="item.image" class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 opacity-100 group-hover:opacity-0" onerror="this.src='https://placehold.co/400?text=No+Image';">
                                </template>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mb-1" x-text="item.name"></h3>
                                <p class="text-xs text-gray-500 mb-2 flex items-center gap-1"><span>🎨</span> <span x-text="item.creator"></span></p>
                                <div class="mt-auto w-full">
                                    <p class="text-xl font-extrabold text-orange-600 mb-4" x-text="item.price === 0 ? 'Gratis' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    <button :class="selectedOutfit === item.id ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-600 hover:bg-orange-50'" class="w-full py-3 rounded-md border-2 font-bold text-sm transition uppercase">
                                        <span x-text="selectedOutfit === item.id ? 'Selected' : 'Select'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="category === 'accessories'">
                    <template x-for="item in filterItems(items.accessories)" :key="item.id">
                        <div class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-4 h-full group cursor-pointer" @click="selectedAccessory = item.id">
                            <div class="aspect-square w-full mb-4 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden">
                                <template x-if="item.id === 'none'"><span class="text-6xl text-gray-300">❌</span></template>
                                <template x-if="item.id !== 'none'">
                                    <img :src="item.image" class="w-full h-full object-contain transform group-hover:scale-105 transition" onerror="this.src='https://placehold.co/400?text=Gambar+Rusak';">
                                </template>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mb-1" x-text="item.name"></h3>
                                <p class="text-xs text-gray-500 mb-2 flex items-center gap-1"><span>🎨</span> <span x-text="item.creator"></span></p>
                                <div class="mt-auto w-full">
                                    <p class="text-xl font-extrabold text-orange-600 mb-4" x-text="item.price === 0 ? 'Gratis' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    <button :class="selectedAccessory === item.id ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-600 hover:bg-orange-50'" class="w-full py-3 rounded-md border-2 font-bold text-sm transition uppercase">
                                        <span x-text="selectedAccessory === item.id ? 'Selected' : 'Select'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="category === 'voice'">
                    <div class="contents">
                        <div class="product-card flex flex-col bg-red-50 border-2 border-red-200 border-dashed rounded-xl p-6 h-full items-center justify-center text-center cursor-pointer hover:border-red-400" @click="selectedVoice = 'record'">
                            <div class="text-5xl mb-4 p-4 bg-white rounded-full shadow-sm">🎙️</div>
                            <h3 class="text-lg font-bold text-red-700 mb-1">Rekam Suara Sendiri</h3>
                            <p class="text-sm text-red-500 mb-4">+ Rp 75.000</p>
                            <div class="flex gap-2 w-full justify-center">
                                <button x-show="!isRecording && !audioUrl" @click.stop="startRecording()" class="bg-red-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow hover:bg-red-700 transition">REC</button>
                                <button x-show="isRecording" @click.stop="stopRecording()" class="bg-gray-800 text-white px-4 py-2 rounded-full text-xs font-bold animate-pulse">STOP</button>
                                <button x-show="audioUrl" @click.stop="speak()" class="bg-green-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow hover:bg-green-700">PLAY</button>
                                <button x-show="audioUrl" @click.stop="audioUrl = null; isRecording = false;" class="bg-gray-300 text-gray-700 px-3 py-2 rounded-full text-xs font-bold hover:bg-gray-400">↺</button>
                            </div>
                            <p x-show="isRecording" class="text-xs text-red-600 font-bold mt-2 animate-pulse">Sedang Merekam...</p>
                        </div>
                        <template x-for="item in filterItems(items.voices)" :key="item.id">
                            <div @click="selectedVoice = item.id; if(item.id !== 'none') speak()" class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-6 h-full cursor-pointer text-center items-center justify-center group" :class="selectedVoice === item.id ? 'ring-2 ring-orange-500 bg-orange-50' : ''">
                                <div class="text-6xl mb-4 group-hover:scale-110 transition" x-text="item.icon"></div>
                                <h3 class="text-lg font-bold text-gray-800 mb-2" x-text="item.name"></h3>
                                <p class="text-xl font-bold text-orange-600 mb-4" x-text="item.price === 0 ? 'Gratis' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                <button :class="selectedVoice === item.id ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-600'" class="w-full py-2 rounded-md font-bold text-sm transition uppercase">Select</button>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="category === 'scent'">
                    <template x-for="item in filterItems(items.scents)" :key="item.id">
                        <div @click="selectedScent = item.id" class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-6 h-full cursor-pointer text-center items-center justify-center group" :class="selectedScent === item.id ? 'ring-2 ring-orange-500 bg-orange-50' : ''">
                            <div class="text-6xl mb-4 group-hover:scale-110 transition" x-text="item.icon"></div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2" x-text="item.name"></h3>
                            <p class="text-xl font-bold text-orange-600 mb-4" x-text="item.price === 0 ? 'Gratis' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                            <button :class="selectedScent === item.id ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-600'" class="w-full py-2 rounded-md font-bold text-sm transition uppercase">Select</button>
                        </div>
                    </template>
                </template>

                <template x-if="category === 'gift'">
                    <div class="col-span-full">
                        <h3 class="font-bold text-gray-700 mb-4 text-xl border-l-4 border-orange-500 pl-3">1. Pilih Kemasan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
                            <template x-for="item in filterItems(items.gifts)" :key="item.id">
                                <div @click="giftBox = item.id" class="product-card flex flex-col bg-white rounded-xl border border-gray-200 p-6 cursor-pointer text-center items-center justify-center group" :class="giftBox === item.id ? 'ring-2 ring-orange-500 bg-orange-50' : ''">
                                    <div class="text-6xl mb-4 group-hover:scale-110 transition" x-text="item.icon"></div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2" x-text="item.name"></h3>
                                    <p class="text-sm font-bold text-orange-600" x-text="item.price === 0 ? 'Gratis' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                </div>
                            </template>
                        </div>

                        <h3 class="font-bold text-gray-700 mb-4 text-xl border-l-4 border-orange-500 pl-3">2. Opsi Packing</h3>
                        <div class="flex gap-4 mb-10">
                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer w-full md:w-1/2 hover:bg-orange-50 transition" :class="dressBear === 'true' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'"><input type="radio" name="dress_option" value="true" x-model="dressBear" class="text-orange-600 w-5 h-5"><div><span class="font-bold text-gray-800 block">Dipakaikan Baju</span><span class="text-xs text-gray-500">Boneka dikirim sudah rapi.</span></div></label>
                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer w-full md:w-1/2 hover:bg-orange-50 transition" :class="dressBear === 'false' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200'"><input type="radio" name="dress_option" value="false" x-model="dressBear" class="text-orange-600 w-5 h-5"><div><span class="font-bold text-gray-800 block">Bungkus Terpisah</span><span class="text-xs text-gray-500">Item dibungkus terpisah.</span></div></label>
                        </div>

                        <div x-show="giftBox !== 'none'" x-transition class="bg-blue-50 border border-blue-100 rounded-xl p-8 flex flex-col md:flex-row gap-8 items-start shadow-sm">
                            <div class="text-center md:w-1/4"><div class="text-8xl mb-2">💌</div><h3 class="font-bold text-gray-800">Kartu Ucapan</h3><p class="text-xs text-gray-500">Tulis pesan manismu</p></div>
                            <div class="flex-1 w-full"><label class="font-bold text-gray-700 block mb-2">Pesan Spesial:</label><textarea x-model="cardMessage" class="w-full h-32 p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none resize-none text-gray-700 shadow-inner" placeholder="Selamat ulang tahun!"></textarea><p class="text-right text-xs text-gray-400 mt-2" x-text="cardMessage.length + '/200 karakter'"></p></div>
                        </div>
                    </div>
                </template>

            </div>
        </main>

        <aside class="w-96 bg-white border-l border-gray-200 flex flex-col z-20 shadow-2xl">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-extrabold text-gray-800">Preview</h3>
                <span class="text-sm font-bold text-gray-400">Total</span>
            </div>

            <div class="flex-1 bg-orange-50 flex items-center justify-center p-6 relative overflow-hidden">
                <div class="w-full h-full flex items-center justify-center relative transition-all duration-300">
                    <img :src="currentImage" class="w-full h-auto max-h-[400px] object-contain drop-shadow-xl z-10" onerror="this.src='https://placehold.co/400?text=Pilih+Boneka';">
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 bg-white">
                <div class="flex justify-between items-end mb-6">
                    <span class="text-gray-500 font-bold mb-1">Total Harga</span>
                    <span class="text-3xl font-extrabold text-orange-600" x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
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
                    <input type="hidden" name="action_type" x-model="actionType">
                    
                    <button type="button" @click="submitForm('cart')" class="w-full bg-white border-2 border-orange-600 text-orange-600 font-bold py-3 rounded-xl hover:bg-orange-50 transition flex items-center justify-center gap-2"><span>👜</span> Masukkan Keranjang</button>
                    <button type="button" @click="submitForm('buy')" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-orange-600/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2"><span>🛒</span> Beli Sekarang</button>
                </form>
            </div>
        </aside>

    </div>
</body>
</html>