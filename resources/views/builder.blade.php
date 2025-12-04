<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
        .pop-in { animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes pop { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        
        /* Animasi saat boneka bicara */
        .talking { animation: talk 0.5s infinite alternate; }
        @keyframes talk { 0% { transform: scale(1); } 100% { transform: scale(1.05); } }
    </style>
</head>
<body class="bg-orange-50/50 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <span class="text-4xl group-hover:animate-bounce">🧸</span>
                    <div>
                        <h1 class="text-2xl font-extrabold text-orange-600 tracking-wide leading-none">Build-A-Teddy</h1>
                        <span class="text-xs text-orange-400 font-bold tracking-widest">WORKSHOP</span>
                    </div>
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Beranda</a>
                    <a href="#" class="text-orange-600 font-bold border-b-2 border-orange-500 py-1">Workshop</a>
                    <a href="{{ route('wardrobe') }}" class="text-gray-600 hover:text-orange-600 font-bold transition border-b-2 border-transparent hover:border-orange-500 py-1">Lemari Saya</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN BUILDER -->
    <main class="flex-grow py-12 px-4"
         x-data="{ 
            currentTab: 'base', 
            selectedBase: 'coklat', 
            selectedOutfit: 'none', 
            selectedAccessory: 'none',
            selectedVoice: 'none',
            customMessage: '',
            isTalking: false, // State untuk animasi bicara

            basePrice: 150000,
            prices: { 
                base: 0, 
                outfit: { 'none': 0, 'kaos': 50000, 'hoodie': 75000, 'dress': 65000 }, 
                accessory: { 'none': 0, 'kacamata': 25000, 'topi': 35000, 'pita': 15000 },
                voice: { 'none': 0, 'love': 30000, 'bday': 30000, 'giggle': 20000, 'custom': 50000 }
            },
            
            get totalPrice() { 
                return this.basePrice + this.prices.outfit[this.selectedOutfit] + this.prices.accessory[this.selectedAccessory] + this.prices.voice[this.selectedVoice]; 
            },
            
            get bearColor() { return this.selectedBase === 'coklat' ? '#8B4513' : (this.selectedBase === 'krem' ? '#F5DEB3' : '#333333'); },
            get bearBellyColor() { return this.selectedBase === 'coklat' ? '#D2691E' : (this.selectedBase === 'krem' ? '#FFF8DC' : '#FFFFFF'); },

            // --- FUNGSI BONEKA BICARA (TTS) ---
            speak() {
                let text = '';
                
                // Tentukan teks berdasarkan pilihan
                if (this.selectedVoice === 'love') text = 'I Love You So Much!';
                else if (this.selectedVoice === 'bday') text = 'Happy Birthday to You!';
                else if (this.selectedVoice === 'giggle') text = 'Hihihi, geli tau!';
                else if (this.selectedVoice === 'custom') text = this.customMessage || 'Halo, aku teman barumu!';
                else return; // Kalau 'none' gak ngomong apa2

                // Fitur Browser Speech Synthesis
                let utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID'; // Bahasa Indonesia/Inggris
                utterance.pitch = 1.2; // Biar suaranya agak cempreng lucu
                utterance.rate = 1;

                this.isTalking = true;
                window.speechSynthesis.speak(utterance);

                utterance.onend = () => {
                    this.isTalking = false;
                };
            }
         }">

        <div class="max-w-7xl mx-auto lg:grid lg:grid-cols-12 lg:gap-12">
            
            <!-- LEFT: PREVIEW CARD -->
            <div class="lg:col-span-5 mb-8 lg:mb-0">
                <div class="sticky top-28">
                    <div class="bg-white rounded-[2rem] shadow-2xl p-8 border-4 border-orange-100 relative overflow-hidden">
                        
                        <h2 class="text-xl font-extrabold text-gray-800 mb-6 text-center tracking-tight">Preview Teddy</h2>

                        <!-- KANVAS BONEKA (Bisa Di-klik buat bicara) -->
                        <!-- Tambahkan @click="speak()" di sini -->
                        <div @click="speak()" 
                             class="relative w-full h-80 flex items-center justify-center bg-orange-50 rounded-3xl border-2 border-dashed border-orange-200 cursor-pointer group hover:bg-orange-100 transition duration-300">
                             
                             <!-- Indikator Suara (Icon Sound) -->
                             <div x-show="selectedVoice !== 'none'" class="absolute top-4 right-4 bg-white/80 p-2 rounded-full shadow-sm z-40 animate-pulse">
                                🔊
                             </div>

                             <!-- Tooltip 'Klik Aku' -->
                             <div class="absolute bottom-4 z-40 bg-gray-800 text-white text-xs px-3 py-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                 Klik perutku! 👇
                             </div>

                             <!-- SVG WRAPPER (Animasi Bicara) -->
                             <div :class="isTalking ? 'talking' : ''" class="relative transition-transform duration-300">
                                 <!-- BASE SVG -->
                                 <svg width="220" height="280" viewBox="0 0 200 250" class="relative z-10">
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
                                <!-- OUTFIT & ACCESSORIES -->
                                <div x-show="selectedOutfit === 'kaos'" class="absolute z-20 top-[110px] left-0 right-0 flex justify-center"><svg width="140" height="100" viewBox="0 0 140 100"><path d="M 40 10 L 100 10 L 120 40 L 100 50 L 90 30 L 90 90 L 50 90 L 50 30 L 40 50 L 20 40 Z" fill="#EF4444" stroke="#B91C1C" stroke-width="2"/><text x="70" y="60" font-size="20" text-anchor="middle" fill="white" font-weight="bold">UAP</text></svg></div>
                                <div x-show="selectedOutfit === 'hoodie'" class="absolute z-20 top-[105px] left-0 right-0 flex justify-center"><svg width="150" height="110" viewBox="0 0 150 110"><path d="M 45 5 L 105 5 L 130 40 L 110 55 L 100 35 L 100 100 L 50 100 L 50 35 L 40 55 L 20 40 Z" fill="#3B82F6" stroke="#1D4ED8" stroke-width="2"/><rect x="65" y="60" width="20" height="25" fill="#2563EB" rx="5" /></svg></div>
                                <div x-show="selectedOutfit === 'dress'" class="absolute z-20 top-[110px] left-0 right-0 flex justify-center"><svg width="140" height="120" viewBox="0 0 140 120"><path d="M 50 10 L 90 10 L 110 90 L 30 90 Z" fill="#EC4899" /><path d="M 30 90 Q 70 110 110 90" fill="#EC4899" /></svg></div>
                                <div x-show="selectedAccessory === 'kacamata'" class="absolute z-30 top-[65px] left-0 right-0 flex justify-center"><svg width="80" height="30" viewBox="0 0 80 30"><circle cx="20" cy="15" r="12" fill="#000" opacity="0.8" /><circle cx="60" cy="15" r="12" fill="#000" opacity="0.8" /><line x1="32" y1="15" x2="48" y2="15" stroke="#000" stroke-width="2" /></svg></div>
                                <div x-show="selectedAccessory === 'topi'" class="absolute z-30 top-[-10px] left-0 right-0 flex justify-center"><svg width="100" height="80" viewBox="0 0 100 80"><rect x="25" y="20" width="50" height="50" fill="#1F2937" /><rect x="10" y="65" width="80" height="10" fill="#1F2937" /><rect x="25" y="55" width="50" height="5" fill="#EF4444" /></svg></div>
                                <div x-show="selectedAccessory === 'pita'" class="absolute z-30 top-[15px] right-[45px]"><svg width="50" height="40" viewBox="0 0 50 40"><path d="M 25 20 L 5 5 L 5 35 Z" fill="#EC4899" /><path d="M 25 20 L 45 5 L 45 35 Z" fill="#EC4899" /><circle cx="25" cy="20" r="5" fill="#BE185D" /></svg></div>
                             </div>
                        </div>

                        <!-- TOTAL PRICE BAR -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-end">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Estimasi</p>
                                <div class="text-3xl font-extrabold text-gray-900" x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></div>
                            </div>
                            <!-- FORM SUBMIT -->
                            <form action="{{ url('/cart/add-custom') }}" method="POST">
                                @csrf
                                <input type="hidden" name="base" :value="selectedBase">
                                <input type="hidden" name="outfit" :value="selectedOutfit">
                                <input type="hidden" name="accessory" :value="selectedAccessory">
                                <input type="hidden" name="voice" :value="selectedVoice">
                                <input type="hidden" name="message" :value="customMessage">
                                <input type="hidden" name="price" :value="totalPrice">
                                
                                <button type="submit" class="bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-1 transition flex items-center gap-2">
                                    Beli Sekarang <span>➜</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: CONTROLS -->
            <div class="lg:col-span-7">
                <!-- TABS (Ada Tab Baru: Suara) -->
                <div class="flex space-x-2 mb-8 bg-white p-2 rounded-full shadow-sm w-full overflow-x-auto">
                    <button @click="currentTab = 'base'" :class="currentTab === 'base' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-100'" class="flex-1 px-4 py-2 rounded-full font-bold transition text-sm whitespace-nowrap">1. Warna</button>
                    <button @click="currentTab = 'outfit'" :class="currentTab === 'outfit' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-100'" class="flex-1 px-4 py-2 rounded-full font-bold transition text-sm whitespace-nowrap">2. Baju</button>
                    <button @click="currentTab = 'accessory'" :class="currentTab === 'accessory' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-100'" class="flex-1 px-4 py-2 rounded-full font-bold transition text-sm whitespace-nowrap">3. Aksesoris</button>
                    <!-- TAB BARU -->
                    <button @click="currentTab = 'voice'" :class="currentTab === 'voice' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-100'" class="flex-1 px-4 py-2 rounded-full font-bold transition text-sm whitespace-nowrap flex items-center gap-1 justify-center"><span>🎤</span> 4. Suara</button>
                </div>

                <div class="bg-white rounded-[2rem] shadow-sm p-8 min-h-[500px] border border-orange-50 relative">
                    
                    <!-- TAB 1: BASE -->
                    <div x-show="currentTab === 'base'" x-transition.opacity>
                        <h3 class="text-2xl font-extrabold text-gray-800 mb-6">Pilih Warna Dasar</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div @click="selectedBase = 'coklat'" :class="selectedBase === 'coklat' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300'" class="cursor-pointer border-2 rounded-3xl p-6 flex flex-col items-center transition group">
                                <div class="w-20 h-20 rounded-full bg-[#8B4513] shadow-inner mb-4 group-hover:scale-110 transition"></div>
                                <span class="font-bold text-gray-700">Choco</span>
                            </div>
                            <div @click="selectedBase = 'krem'" :class="selectedBase === 'krem' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300'" class="cursor-pointer border-2 rounded-3xl p-6 flex flex-col items-center transition group">
                                <div class="w-20 h-20 rounded-full bg-[#F5DEB3] shadow-inner mb-4 border border-gray-300 group-hover:scale-110 transition"></div>
                                <span class="font-bold text-gray-700">Cream</span>
                            </div>
                            <div @click="selectedBase = 'panda'" :class="selectedBase === 'panda' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300'" class="cursor-pointer border-2 rounded-3xl p-6 flex flex-col items-center transition group">
                                <div class="w-20 h-20 rounded-full bg-gray-800 shadow-inner mb-4 border-4 border-white group-hover:scale-110 transition"></div>
                                <span class="font-bold text-gray-700">Panda</span>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: OUTFIT -->
                    <div x-show="currentTab === 'outfit'" x-transition.opacity style="display: none;">
                        <h3 class="text-2xl font-extrabold text-gray-800 mb-6">Pilih Outfit Keren</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div @click="selectedOutfit = 'none'" :class="selectedOutfit === 'none' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">🚫</span><span class="font-bold text-gray-700">Polos</span>
                            </div>
                            <div @click="selectedOutfit = 'kaos'" :class="selectedOutfit === 'kaos' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">👕</span><span class="font-bold text-gray-700">Kaos</span><span class="block text-xs font-bold text-orange-500 mt-1">+50rb</span>
                            </div>
                            <div @click="selectedOutfit = 'hoodie'" :class="selectedOutfit === 'hoodie' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">🧥</span><span class="font-bold text-gray-700">Hoodie</span><span class="block text-xs font-bold text-orange-500 mt-1">+75rb</span>
                            </div>
                            <div @click="selectedOutfit = 'dress'" :class="selectedOutfit === 'dress' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">👗</span><span class="font-bold text-gray-700">Dress</span><span class="block text-xs font-bold text-orange-500 mt-1">+65rb</span>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: ACCESSORY -->
                    <div x-show="currentTab === 'accessory'" x-transition.opacity style="display: none;">
                        <h3 class="text-2xl font-extrabold text-gray-800 mb-6">Tambahkan Aksesoris</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div @click="selectedAccessory = 'none'" :class="selectedAccessory === 'none' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">🚫</span><span class="font-bold text-gray-700">Polos</span>
                            </div>
                            <div @click="selectedAccessory = 'kacamata'" :class="selectedAccessory === 'kacamata' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">😎</span><span class="font-bold text-gray-700">Kacamata</span><span class="block text-xs font-bold text-orange-500 mt-1">+25rb</span>
                            </div>
                            <div @click="selectedAccessory = 'topi'" :class="selectedAccessory === 'topi' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">🎩</span><span class="font-bold text-gray-700">Topi</span><span class="block text-xs font-bold text-orange-500 mt-1">+35rb</span>
                            </div>
                            <div @click="selectedAccessory = 'pita'" :class="selectedAccessory === 'pita' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-3xl p-6 text-center hover:shadow-lg transition">
                                <span class="text-4xl block mb-3">🎀</span><span class="font-bold text-gray-700">Pita</span><span class="block text-xs font-bold text-orange-500 mt-1">+15rb</span>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 4: VOICE (NEW!) -->
                    <div x-show="currentTab === 'voice'" x-transition.opacity style="display: none;">
                        <h3 class="text-2xl font-extrabold text-gray-800 mb-2">Costume Voice 🎤</h3>
                        <p class="text-gray-500 mb-6">Pencet bonekanya untuk tes suara!</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Opsi 1: Hening -->
                            <div @click="selectedVoice = 'none'; speak()" :class="selectedVoice === 'none' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-2xl p-4 flex items-center gap-4">
                                <span class="text-2xl">🔇</span>
                                <div><h4 class="font-bold">Tanpa Suara</h4><p class="text-xs text-gray-500">Gratis</p></div>
                            </div>
                            <!-- Opsi 2: I Love You -->
                            <div @click="selectedVoice = 'love'; speak()" :class="selectedVoice === 'love' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-2xl p-4 flex items-center gap-4">
                                <span class="text-2xl">❤️</span>
                                <div><h4 class="font-bold">I Love You</h4><p class="text-xs text-orange-500 font-bold">+30rb</p></div>
                            </div>
                            <!-- Opsi 3: Birthday -->
                            <div @click="selectedVoice = 'bday'; speak()" :class="selectedVoice === 'bday' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-2xl p-4 flex items-center gap-4">
                                <span class="text-2xl">🎂</span>
                                <div><h4 class="font-bold">Happy Birthday</h4><p class="text-xs text-orange-500 font-bold">+30rb</p></div>
                            </div>
                            <!-- Opsi 4: Giggle -->
                            <div @click="selectedVoice = 'giggle'; speak()" :class="selectedVoice === 'giggle' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-2xl p-4 flex items-center gap-4">
                                <span class="text-2xl">😂</span>
                                <div><h4 class="font-bold">Ketawa Lucu</h4><p class="text-xs text-orange-500 font-bold">+20rb</p></div>
                            </div>
                        </div>

                        <!-- Opsi 5: Custom Record -->
                        <div @click="selectedVoice = 'custom'; speak()" :class="selectedVoice === 'custom' ? 'ring-4 ring-orange-200 border-orange-500 bg-orange-50' : 'border-gray-200'" class="cursor-pointer border-2 rounded-2xl p-4 mt-4">
                            <div class="flex items-center gap-4 mb-3">
                                <span class="text-2xl">🎙️</span>
                                <div><h4 class="font-bold">Pesan Kustom</h4><p class="text-xs text-orange-500 font-bold">+50rb</p></div>
                            </div>
                            <input type="text" x-model="customMessage" @click.stop placeholder="Ketik ucapanmu di sini..." class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-orange-500 outline-none">
                            <p class="text-xs text-gray-400 mt-2 italic">*Boneka akan bicara sesuai teks ini.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-2xl block mb-2">🧸</span>
            <p class="text-sm">&copy; 2025 Build-A-Teddy. Designed for UAP Web Programming.</p>
        </div>
    </footer>
</body>
</html>