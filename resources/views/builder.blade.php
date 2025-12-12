<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teddy Workshop - Custom Your Teddy</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, h4, .font-display { font-family: 'Fredoka', sans-serif; }
        
        [x-cloak] { display: none !important; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Minimalist UI & Uniform Card Height */
        .product-card { 
            transition: all 0.2s ease-in-out; 
            touch-action: manipulation;
            height: 350px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #FFEDD5; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); 
        }
        .product-card:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 8px 15px -3px rgba(249, 115, 22, 0.15); 
            border-color: #f97316; 
        }
        
        .double-tap-hint { opacity: 0; transition: opacity 0.3s; }
        .product-card:hover .double-tap-hint { opacity: 1; }

        /* LIVE LAYER STYLES */
        .preview-layer {
            position: absolute;
            top: 5%;
            left: 5%;
            width: 90%;
            height: 90%;
            object-fit: contain;
            transition: opacity 0.3s;
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workshopState', () => ({
                // === STATE ===
                search: '', category: 'body',
                selectedBase: 'coklat', selectedSize: 'M',
                selectedOutfit: 'none', selectedAccessory: 'none', 
                selectedVoice: 'none', selectedScent: 'none',
                giftBox: 'none', cardMessage: '', dressBear: 'true',
                actionType: 'cart',
                
                cartCount: {{ $cartCount ?? 0 }}, 
                isSubmitting: false,

                // === MODAL STATE ===
                activeItem: null,
                isModalOpen: false,
                tempSize: 'M', // Digunakan untuk Body, namun tetap muncul untuk Outfit/Accs

                // === HEADER JUDUL ===
                get headerTitle() {
                    const titles = { 'body': 'Pilih Karakter', 'clothing': 'Outfit & Kostum', 'accessories': 'Aksesoris Lucu', 'voice': 'Modul Suara', 'scent': 'Pilihan Aroma', 'gift': 'Packing Spesial' };
                    return titles[this.category] || 'Katalog';
                },

                // === LOGIC LAYERED PREVIEW ===
                getBodyImg() {
                    let item = this.items.bodies.find(i => i.id === this.selectedBase)?.image;
                    return item || `{{ asset('picture/bonekaCoklat.png') }}`;
                },
                getOutfitImg() {
                    if (this.selectedOutfit === 'none') return '';
                    let item = this.items.outfits.find(i => i.id === this.selectedOutfit); return item ? item.image_worn : '';
                },
                getAccImg() {
                    if (this.selectedAccessory === 'none') return '';
                    let item = this.items.accessories.find(i => i.id === this.selectedAccessory); return item ? item.image_worn : '';
                },
                
                // FUNGSI UTAMA UNTUK MEMILIH ITEM
                selectItem(item) {
                    if (this.category === 'body') { this.selectedBase = item.id; this.selectedSize = 'M'; }
                    else if (this.category === 'clothing') this.selectedOutfit = item.id;
                    else if (this.category === 'accessories') this.selectedAccessory = item.id;
                    else if (this.category === 'voice') this.selectedVoice = item.id;
                    else if (this.category === 'scent') this.selectedScent = item.id;
                    else if (this.category === 'gift') this.giftBox = item.id;
                },


                // === MODAL LOGIC ===
                openModal(item) {
                    if (['voice', 'scent', 'gift'].includes(this.category)) return;
                    this.activeItem = item;
                    // FIX: Tentukan tempSize berdasarkan kategori
                    this.tempSize = (this.category === 'body') ? this.selectedSize : 'M'; 
                    this.isModalOpen = true;
                },
                closeModal() {
                    this.isModalOpen = false;
                    setTimeout(() => { this.activeItem = null }, 300);
                },
                applyItemFromModal() {
                    if(!this.activeItem) return;
                    
                    if (this.category === 'body') { 
                        this.selectedBase = this.activeItem.id; 
                        this.selectedSize = this.tempSize; 
                    }
                    // Outfit/Accessories: Update item dan simpan size yang dipilih
                    else if (this.category === 'clothing') {
                        this.selectedOutfit = this.activeItem.id;
                        this.selectedSize = this.tempSize; // Simpan size yang dipilih (meski tidak mempengaruhi harga outfit)
                    }
                    else if (this.category === 'accessories') {
                        this.selectedAccessory = this.activeItem.id;
                        this.selectedSize = this.tempSize; // Simpan size yang dipilih (meski tidak mempengaruhi harga acc)
                    }
                    
                    this.closeModal();
                },
                getAdjustedPrice(basePrice) {
                    if (this.category === 'body') {
                        if (this.tempSize === 'S') return basePrice - 20000;
                        if (this.tempSize === 'XL') return basePrice + 50000;
                    }
                    // FIX: Harga Outfit/Accs TIDAK berubah berdasarkan size
                    return basePrice;
                },

                items: {
                    bodies: [
                        { id: 'coklat', name: 'Choco Bear', price: 150000, desc: 'Beruang coklat klasik yang lembut.', image: `{{ asset('picture/bonekaCoklat.png') }}` },
                        { id: 'krem', name: 'Cream Bear', price: 150000, desc: 'Warna krem yang cerah dan manis.', image: `{{ asset('picture/bonekaCream.png') }}` },
                        { id: 'polar', name: 'Polar Bear', price: 155000, desc: 'Teman dari kutub utara yang sejuk.', image: `{{ asset('picture/polarBear.png') }}` },
                        { id: 'panda', name: 'Mr. Panda', price: 160000, desc: 'Hitam putih yang ikonik.', image: `{{ asset('picture/panda.png') }}` },
                        { id: 'pink', name: 'Pinky Bear', price: 150000, desc: 'Penuh cinta dengan warna pink.', image: `{{ asset('picture/bearPink.png') }}` },
                        { id: 'deer', name: 'Grey Deer', price: 175000, desc: 'Rusa abu-abu yang unik.', image: `{{ asset('picture/greyDeer.png') }}` },
                        { id: 'kitty', name: 'Hello Kitty', price: 200000, desc: 'Karakter favorit semua orang.', image: `{{ asset('picture/helloKitty.png') }}` },
                        { id: 'bluey', name: 'Bluey', price: 180000, desc: 'Berwarna biru ceria.', image: `{{ asset('picture/bluey.png') }}` },
                        { id: 'bunny', name: 'Purple Bunny', price: 165000, image: `{{ asset('picture/purpleBunny.png') }}` },
                        { id: 'cinamon', name: 'Green Cinnamon', price: 185000, image: `{{ asset('picture/greenCinamon.png') }}` }
                    ],
                    outfits: [
                        { id: 'none', name: 'Lepas Baju', price: 0, desc: 'Tampil natural.', image: '', creator: '-' },
                        { id: 'tuxedo', name: 'Tuxedo Hitam', price: 95000, desc: 'Tampil formal dan elegan.', creator: 'MrFormal', image: `{{ asset('picture/tuxedo.png') }}`, image_worn: `{{ asset('picture/tuxedo-worn.png') }}` },
                        { id: 'kaos', name: 'Kaos Merah', price: 50000, desc: 'Kasual dan santai.', creator: 'SimpleStyle', image: `{{ asset('picture/kaos-merah.png') }}`, image_worn: `{{ asset('picture/kaos-merah-worn.png') }}` },
                        { id: 'hoodie', name: 'Hoodie Biru', price: 75000, desc: 'Hangat dan stylish.', creator: 'StreetWear', image: `{{ asset('picture/hoodie-biru.png') }}`, image_worn: `{{ asset('picture/hoodie-biru-worn.png') }}` },
                        { id: 'dress', name: 'Dress Pink', price: 65000, desc: 'Cantik dan anggun.', creator: 'Princess', image: `{{ asset('picture/dress-pink.png') }}`, image_worn: `{{ asset('picture/dress-pink-worn.png') }}` },
                        { id: 'piyama', name: 'Piyama Tidur', price: 55000, desc: 'Siap mimpi indah.', creator: 'Sleepy', image: `{{ asset('picture/piyama.png') }}`, image_worn: `{{ asset('picture/piyama-worn.png') }}` },
                        { id: 'denim', name: 'Jaket Denim', price: 85000, desc: 'Tampil keren dengan denim.', creator: 'DenimStyle', image: `{{ asset('picture/jaket-denim.png') }}`, image_worn: `{{ asset('picture/jaket-denim-worn.png') }}` },
                        { id: 'polisi', name: 'Seragam Polisi', price: 80000, desc: 'Siap menjaga keamanan.', creator: 'Police', image: `{{ asset('picture/polisi.png') }}`, image_worn: `{{ asset('picture/polisi-worn.png') }}` },
                        { id: 'dokter', name: 'Jas Dokter', price: 75000, desc: 'Cita-cita mulia.', creator: 'Medic', image: `{{ asset('picture/dokter.png') }}`, image_worn: `{{ asset('picture/dokter-worn.png') }}` },
                        { id: 'astronaut', name: 'Astronaut', price: 120000, desc: 'Menjelajah luar angkasa.', creator: 'NASA', image: `{{ asset('picture/astronaut.png') }}`, image_worn: `{{ asset('picture/astronaut-worn.png') }}` }
                    ],
                    accessories: [
                        { id: 'none', name: 'Lepas Acc', price: 0, desc: '-', image: '', creator: '-' },
                        { id: 'kacamata', name: 'Kacamata', price: 25000, desc: 'Tampil gaya.', creator: 'SunGlasses', image: `{{ asset('picture/kacamata.png') }}`, image_worn: `{{ asset('picture/kacamata-worn.png') }}` },
                        { id: 'topi', name: 'Topi Sulap', price: 35000, desc: 'Abrakadabra!', creator: 'Magic', image: `{{ asset('picture/topi.png') }}`, image_worn: `{{ asset('picture/topi-worn.png') }}` },
                        { id: 'pita', name: 'Pita Lucu', price: 15000, desc: 'Sentuhan manis.', creator: 'Cute', image: `{{ asset('picture/pita.png') }}`, image_worn: `{{ asset('picture/pita-worn.png') }}` },
                        { id: 'mahkota', name: 'Mahkota', price: 45000, desc: 'Untuk raja dan ratu.', creator: 'Royal', image: `{{ asset('picture/mahkota.png') }}`, image_worn: `{{ asset('picture/mahkota-worn.png') }}` },
                        { id: 'earmuff', name: 'Earmuff', price: 40000, desc: 'Penghangat telinga fluffy.', creator: 'Winter', image: `{{ asset('picture/earmuff.png') }}`, image_worn: `{{ asset('picture/earmuff-worn.png') }}` },
                        { id: 'tas', name: 'Tas', price: 30000, desc: 'Siap membawa bekal.', creator: 'Adventure', image: `{{ asset('picture/tas.png') }}`, image_worn: `{{ asset('picture/tas-worn.png') }}` },
                        { id: 'syal', name: 'Syal', price: 20000, desc: 'Menjaga leher hangat.', creator: 'Winter', image: `{{ asset('picture/syal.png') }}`, image_worn: `{{ asset('picture/syal-worn.png') }}` },
                        { id: 'bunga', name: 'Bunga', price: 15000, desc: 'Segar dan harum.', creator: 'Florist', image: `{{ asset('picture/bunga.png') }}`, image_worn: `{{ asset('picture/bunga-worn.png') }}` },
                        { id: 'masker', name: 'Masker', price: 10000, desc: 'Jaga kesehatan.', creator: 'Health', image: `{{ asset('picture/masker.png') }}`, image_worn: `{{ asset('picture/masker-worn.png') }}` }
                    ],
                    voices: [
                        { id: 'none', name: 'Silent', price: 0, icon: '🔇', speakText: 'Silence. No sound module selected.' },
                        { id: 'love', name: 'I Love You', price: 30000, icon: '❤️', speakText: 'I love you more than honey and the stars above!' },
                        { id: 'bday', name: 'Happy Birthday', price: 30000, icon: '🎂', speakText: 'Happy birthday to you! May your day be sweet and full of joy!' },
                        { id: 'laugh', name: 'Funny Laugh', price: 25000, icon: '😂', speakText: 'Ha. Ha. Ha. A very deep, booming laugh sound effect.' },
                        { id: 'lullaby', name: 'Lullaby Song', price: 35000, icon: '🌙', speakText: 'Twinkle twinkle little star, how I wonder what you are. Up above the world so high, like a diamond in the sky. Sleep tight, little one.' },
                        { id: 'congrats', name: 'Congratulations', price: 30000, icon: '🎉', speakText: 'Congratulations on your success! You did it!' },
                        { id: 'gws', name: 'Get Well Soon', price: 30000, icon: '💊', speakText: 'Sending warm hugs and wishing you a speedy recovery. Get well soon!' },
                        { id: 'morning', name: 'Morning Alarm', price: 25000, icon: '⏰', speakText: 'Wake up! Wake up! Good morning, sunshine! It is time to wake up and play.' },
                        { id: 'animal', name: 'Animal Sound', price: 25000, icon: '🐱', speakText: 'Meow meow. Woof woof. Rrrroooar.' },
                        { id: 'sorry', name: 'I am Sorry', price: 30000, icon: '🙏', speakText: 'I am so sorry. Please forgive me, I really miss you.' }
                    ],
                    scents: [
                        { id: 'none', name: 'No Scent', price: 0, icon: '👃' },
                        { id: 'vanilla', name: 'Vanilla', price: 15000, icon: '🍦' },
                        { id: 'strawberry', name: 'Strawberry', price: 15000, icon: '🍓' },
                        { id: 'chocolate', name: 'Coklat', price: 15000, icon: '🍫' },
                        { id: 'bubblegum', name: 'Bubblegum', price: 20000, icon: '🍬' },
                        { id: 'lavender', name: 'Lavender', price: 20000, icon: '🪻' },
                        { id: 'coffee', name: 'Kopi', price: 15000, icon: '☕' },
                        { id: 'rose', name: 'Mawar', price: 20000, icon: '🌹' },
                        { id: 'lemon', name: 'Lemon', price: 15000, icon: '🍋' },
                        { id: 'baby', name: 'Baby Powder', price: 20000, icon: '👶' }
                    ],
                    gifts: [
                        { id: 'none', name: 'Standard Box', price: 0, icon: '📦' },
                        { id: 'premium', name: 'Premium Gift', price: 25000, icon: '🎀' },
                        { id: 'birthday', name: 'Birthday Box', price: 30000, icon: '🎂' },
                        { id: 'love', name: 'Valentine', price: 35000, icon: '💘' },
                        { id: 'christmas', name: 'Xmas', price: 35000, icon: '🎄' },
                        { id: 'lebaran', name: 'Eid', price: 30000, icon: '🕌' },
                        { id: 'graduation', name: 'Graduation', price: 30000, icon: '🎓' },
                        { id: 'mystery', name: 'Mystery', price: 50000, icon: '❓' },
                        { id: 'transparent', name: 'Clear Case', price: 60000, icon: '💎' },
                        { id: 'basket', name: 'Picnic Basket', price: 45000, icon: '🧺' }
                    ]
                },

                filterItems(list) { 
                    if (this.search === '') return list;
                    return list.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase())); 
                },
                
                get totalPrice() { 
                    // 1. Base Price + Size Adjustment
                    let base = this.items.bodies.find(i => i.id === this.selectedBase)?.price || 0;
                    if (this.selectedSize === 'S') base -= 20000;
                    if (this.selectedSize === 'XL') base += 50000;
                    
                    const getItemPrice = (id, category) => this.items[category].find(i => i.id === id)?.price || 0;

                    let outfit = getItemPrice(this.selectedOutfit, 'outfits');
                    let acc = getItemPrice(this.selectedAccessory, 'accessories');
                    let voice = getItemPrice(this.selectedVoice, 'voices');
                    let scent = getItemPrice(this.selectedScent, 'scents');
                    let gift = getItemPrice(this.giftBox, 'gifts');

                    return base + outfit + acc + voice + scent + gift;
                },

                submitForm(type) { 
                    this.actionType = type;
                    const form = this.$refs.formBuilder;
                    this.isSubmitting = true;
                    
                    if (type === 'buy') {
                        form.submit();
                        return;
                    }

                    // --- Logika AJAX untuk 'cart' (Tetap di halaman Workshop) ---
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else if (response.status === 419) {
                            alert('Sesi Anda habis. Silakan refresh halaman dan coba lagi.');
                            throw new Error('CSRF Token Mismatch');
                        } else {
                            throw new Error('Server returned non-JSON response (Check Login/Validation)');
                        }
                    })
                    .then(data => {
                        this.isSubmitting = false;

                        if (data.success) {
                            // 1. Update Badge Keranjang
                            this.cartCount = data.cart_count;
                            
                            // 2. Reset state
                            this.category = 'body'; 
                            this.selectedBase = 'coklat';
                            this.selectedOutfit = 'none';
                            this.selectedAccessory = 'none';
                            this.selectedVoice = 'none';
                            this.selectedScent = 'none';
                            this.giftBox = 'none';
                            this.cardMessage = '';

                            alert(`Item berhasil dimasukkan ke keranjang! Total Item: ${data.cart_count}`);
                            
                        } else {
                            alert('Gagal menambahkan item: ' + data.message);
                        }
                    })
                    .catch(error => {
                        this.isSubmitting = false;
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menambahkan item. Pastikan Anda sudah login dan data valid.');
                    });
                },

                // REKAM SUARA & PLAY SIMULASI (FINAL FIX - Menggunakan TTS Bahasa Inggris)
                isRecording: false, audioBlob: null, audioUrl: null, mediaRecorder: null, audioChunks: [],
                startRecording() {
                    this.selectedVoice = 'record'; navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                        this.mediaRecorder = new MediaRecorder(stream); this.audioChunks = [];
                        this.mediaRecorder.ondataavailable = (event) => { if (event.data.size > 0) this.audioChunks.push(event.data); };
                        this.mediaRecorder.onstop = () => { this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' }); this.audioUrl = URL.createObjectURL(this.audioBlob); this.isRecording = false; stream.getTracks().forEach(track => track.stop()); };
                        this.mediaRecorder.start(100); this.isRecording = true;
                    }).catch(error => { alert('Gagal akses mikrofon.'); });
                },
                stopRecording() { if(this.mediaRecorder && this.mediaRecorder.state !== 'inactive') this.mediaRecorder.stop(); },
                
                // FUNGSI PLAY SUARA UNTUK MODUL YANG DIBELI (TTS)
                speak(voiceId) {
                    const soundId = voiceId || this.selectedVoice;
                    if (soundId === 'record') { 
                        if (this.audioUrl) new Audio(this.audioUrl).play(); 
                        else alert('Record voice first!'); 
                        return; 
                    }
                    if(soundId === 'none') return; 
                    
                    // Ambil teks yang lebih panjang dan kontekstual
                    const item = this.items.voices.find(v => v.id === soundId);
                    let textToSpeak = 'Hello there!';

                    if (item) {
                        switch(item.id) {
                            case 'love': 
                                textToSpeak = 'I love you more than honey and the stars above!'; break;
                            case 'bday': 
                                textToSpeak = 'Happy birthday to you! May your day be sweet and full of joy!'; break;
                            case 'lullaby':
                                // Lirik Lullaby/Twinkle Twinkle
                                textToSpeak = 'Twinkle twinkle little star, how I wonder what you are. Up above the world so high, like a diamond in the sky. Sleep tight, little one.';
                                break;
                            case 'congrats':
                                textToSpeak = 'Congratulations on your success! You did it!'; break;
                            case 'gws':
                                textToSpeak = 'Sending warm hugs and wishing you a speedy recovery. Get well soon!'; break;
                            case 'laugh':
                                textToSpeak = 'Ha. Ha. Ha. A very deep, booming laugh sound effect.'; break;
                            case 'morning':
                                textToSpeak = 'Wake up! Wake up! Good morning, sunshine! It is time to wake up and play.'; break;
                            case 'animal':
                                textToSpeak = 'Meow meow. Woof woof. Rrrroooar.'; break;
                            case 'sorry':
                                textToSpeak = 'I am so sorry. Please forgive me, I really miss you.'; break;
                            default:
                                textToSpeak = item.name + ' activated. Roar!';
                        }
                    }
                    
                    let u = new SpeechSynthesisUtterance(textToSpeak); 
                    u.lang = 'en-US'; // Bahasa Inggris
                    window.speechSynthesis.speak(u);
                }
            }))
        })
    </script>
</head>

<body class="h-screen flex flex-col overflow-hidden text-gray-800" x-data="workshopState">
    
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-orange-900/40 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="isModalOpen" x-transition.scale class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border-4 border-orange-100">
                <button @click="closeModal()" class="absolute top-6 right-6 z-10 p-2 bg-orange-50 hover:bg-orange-100 rounded-full transition text-orange-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex flex-col md:flex-row h-full">
                    <div class="w-full md:w-1/2 bg-orange-50/50 p-12 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f97316_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        <template x-if="activeItem"><img :src="activeItem.image || 'https://placehold.co/400'" class="w-full h-auto max-h-[350px] object-contain drop-shadow-2xl hover:scale-110 transition duration-500 relative z-10"></template>
                    </div>
                    <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                        <template x-if="activeItem">
                            <div>
                                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-extrabold rounded-full uppercase tracking-wider mb-4">Official Merchandise</span>
                                <h2 class="text-4xl font-display font-extrabold text-gray-900 mb-2 leading-tight" x-text="activeItem.name"></h2>
                                <p class="text-xs text-gray-400 font-bold mb-6 flex items-center gap-1">🎨 Designed by <span x-text="activeItem.creator || 'Build-A-Teddy'"></span></p>
                                
                                <p class="text-5xl font-display font-extrabold text-orange-600 mb-8" x-text="getAdjustedPrice(activeItem.price) === 0 ? 'Gratis' : 'Rp ' + getAdjustedPrice(activeItem.price).toLocaleString('id-ID')"></p>
                                
                                <template x-if="['body', 'clothing', 'accessories'].includes(category)">
                                    <div class="mb-8 p-4 bg-orange-50 rounded-2xl border border-orange-100">
                                        <p class="text-xs font-bold text-orange-800 uppercase mb-3">Pilih Ukuran:</p>
                                        <div class="flex gap-3">
                                            <button @click="tempSize = 'S'" :class="tempSize === 'S' ? 'bg-orange-600 text-white shadow-lg transform scale-105' : 'bg-white text-gray-500 hover:border-orange-300'" class="flex-1 py-3 rounded-xl font-bold text-sm transition border-2 border-transparent">S<br><span class="text-[10px] opacity-70 font-normal">30cm</span></button>
                                            <button @click="tempSize = 'M'" :class="tempSize === 'M' ? 'bg-orange-600 text-white shadow-lg transform scale-105' : 'bg-white text-gray-500 hover:border-orange-300'" class="flex-1 py-3 rounded-xl font-bold text-sm transition border-2 border-transparent">M<br><span class="text-[10px] opacity-70 font-normal">50cm</span></button>
                                            <button @click="tempSize = 'XL'" :class="tempSize === 'XL' ? 'bg-orange-600 text-white shadow-lg transform scale-105' : 'bg-white text-gray-500 hover:border-orange-300'" class="flex-1 py-3 rounded-xl font-bold text-sm transition border-2 border-transparent">XL<br><span class="text-[10px] opacity-70 font-normal">80cm</span></button>
                                        </div>
                                    </div>
                                </template>

                                <button @click="applyItemFromModal()" class="w-full bg-orange-600 text-white font-display font-bold text-lg py-4 px-6 rounded-2xl shadow-sm hover:bg-orange-700 hover:shadow-md hover:-translate-y-0.5 transition transform flex items-center justify-center gap-3">
                                    <span>✨</span> Pasang Item Ini
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 h-20 flex items-center px-8 justify-between flex-none z-50 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <span class="text-4xl group-hover:rotate-12 transition transform duration-300">🧸</span>
                <div class="hidden md:block leading-tight">
                    <span class="font-display font-extrabold text-orange-600 text-2xl tracking-wide block">BUILD-A-TEDDY</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">The Workshop</span>
                </div>
            </a>
        </div>
        
        <div class="hidden md:flex flex-1 max-w-xl mx-12 relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-orange-300 group-focus-within:text-orange-500 transition"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
            <input type="text" x-model="search" placeholder="Cari baju, aksesoris..." class="w-full bg-orange-50/50 border-2 border-transparent rounded-2xl py-3 pl-14 pr-6 focus:ring-0 focus:border-orange-300 focus:bg-white outline-none text-base font-bold transition-all text-gray-700 placeholder-orange-200 shadow-inner">
        </div>
        
        <div class="flex items-center gap-6" x-data="{ openProfile: false }">
            <a href="{{ route('wardrobe') }}" class="relative group p-2 rounded-xl hover:bg-orange-50 transition">
                <span class="text-3xl text-gray-400 group-hover:text-orange-500 transition">🛍️</span>
                <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm" x-text="cartCount">
                    {{ $cartCount ?? 0 }} 
                </span>
            </a>
            
            <div class="relative">
                <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-3 focus:outline-none group">
                    <div class="w-11 h-11 bg-orange-100 rounded-full border-2 border-orange-200 flex items-center justify-center font-display font-bold text-orange-600 text-lg group-hover:bg-orange-600 group-hover:text-white transition shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </button>
                <div x-show="openProfile" x-transition class="absolute right-0 mt-4 w-64 bg-white rounded-3xl shadow-sm border border-orange-100 py-2 z-50 overflow-hidden">
                    <div class="px-6 py-4 bg-orange-50/50 border-b border-orange-100">
                        <p class="text-xs text-orange-400 font-bold uppercase tracking-wider">Signed in as</p>
                        <p class="text-sm font-display font-bold text-gray-800 truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm font-bold text-gray-600 hover:bg-orange-50 hover:text-orange-600 rounded-xl transition">Settings</a>
                        <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit" class="w-full text-left px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 rounded-xl transition">Log Out</button> </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-1 flex overflow-hidden">
        
        <aside class="w-28 bg-white border-r border-orange-100 flex flex-col items-center py-8 gap-5 z-10 overflow-y-auto hide-scroll shadow-[4px_0_24px_rgba(249,115,22,0.05)]">
            <template x-for="cat in [{id: 'body', icon: '🐻', label: 'Body'}, {id: 'clothing', icon: '👕', label: 'Outfit'}, {id: 'accessories', icon: '👓', label: 'Accs'}, {id: 'voice', icon: '🎤', label: 'Suara'}, {id: 'scent', icon: '🌸', label: 'Aroma'}, {id: 'gift', icon: '🎁', label: 'Gift'}]">
                <button @click="category = cat.id" 
                        :class="category === cat.id ? 'bg-orange-600 text-white shadow-md shadow-orange-500/40 scale-110' : 'text-gray-400 bg-white hover:bg-orange-50 hover:text-orange-500'" 
                        class="w-16 h-16 rounded-3xl text-3xl transition-all duration-300 flex flex-col items-center justify-center gap-1 group relative">
                    <span x-text="cat.icon" class="filter drop-shadow-sm"></span>
                </button>
            </template>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto hide-scroll bg-orange-50/30">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-4xl font-display font-extrabold text-gray-800 tracking-tight" x-text="headerTitle"></h2>
                    <p class="text-gray-500 font-bold mt-2 text-sm">Custom boneka impianmu sesuka hati!</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 **xl:grid-cols-4** gap-6 pb-32">
                
                <template x-if="category === 'body'">
                    <template x-for="item in filterItems(items.bodies)" :key="item.id">
                        <div class="product-card bg-white rounded-[2rem] p-4 h-full cursor-pointer border border-orange-100 relative group" 
                             @click="selectItem(item)" 
                             @dblclick="openModal(item)" 
                             :class="selectedBase === item.id ? 'ring-1 ring-orange-400 border-orange-500 shadow-md' : ''">
                            <div class="aspect-square w-full mb-4 flex items-center justify-center bg-orange-50 rounded-[1.5rem] overflow-hidden p-4 relative">
                                <span class="double-tap-hint absolute top-3 right-3 bg-white/90 backdrop-blur text-orange-600 text-[10px] font-bold px-3 py-1.5 rounded-full shadow-sm pointer-events-none z-10 border border-orange-100">Tap 2x Detail</span>
                                <img :src="item.image" class="w-full h-full object-contain drop-shadow-md group-hover:scale-110 transition duration-500">
                            </div>
                            <div class="px-2">
                                <h3 class="text-lg font-display font-bold text-gray-800 leading-tight mb-1" x-text="item.name"></h3>
                                <div class="mt-3">
                                    <p class="text-xl font-display font-extrabold text-orange-600 mb-3" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    <button class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all" :class="selectedBase === item.id ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500 hover:bg-orange-100 hover:text-orange-600'">
                                        <span x-text="selectedBase === item.id ? 'TERPILIH' : 'PILIH'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="['clothing', 'accessories'].includes(category)">
                    <template x-for="item in filterItems(category === 'clothing' ? items.outfits : items.accessories)" :key="item.id">
                        <div class="product-card bg-white rounded-[2rem] p-4 h-full cursor-pointer border border-orange-100 relative group" 
                             @click="selectItem(item)" 
                             @dblclick="openModal(item)" 
                             :class="(category === 'clothing' ? selectedOutfit : selectedAccessory) === item.id ? 'ring-1 ring-orange-400 border-orange-500 shadow-md' : ''">
                            <div class="aspect-square w-full mb-4 flex items-center justify-center bg-gray-50 rounded-[1.5rem] overflow-hidden p-4 relative">
                                <span class="double-tap-hint absolute top-3 right-3 bg-white/90 backdrop-blur text-orange-600 text-[10px] font-bold px-3 py-1.5 rounded-full shadow-sm pointer-events-none z-10 border border-orange-100">Tap 2x Detail</span>
                                <template x-if="item.id === 'none'"><span class="text-5xl text-gray-300 opacity-50">❌</span></template>
                                <template x-if="item.id !== 'none'"><img :src="item.image" class="w-full h-full object-contain drop-shadow-sm group-hover:scale-110 transition duration-500"></template>
                            </div>
                            <div class="px-2">
                                <h3 class="text-lg font-display font-bold text-gray-800 leading-tight mb-1" x-text="item.name"></h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">by <span x-text="item.creator"></span></p>
                                <div class="mt-auto">
                                    <p class="text-xl font-display font-extrabold text-orange-600 mb-3" x-text="item.price === 0 ? 'GRATIS' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    <button class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all" :class="(category === 'clothing' ? selectedOutfit : selectedAccessory) === item.id ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500 hover:bg-orange-100 hover:text-orange-600'">
                                        <span x-text="(category === 'clothing' ? selectedOutfit : selectedAccessory) === item.id ? 'TERPAKAI' : 'PAKAI'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="['voice', 'scent', 'gift'].includes(category)">
                    <div class="col-span-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 **xl:grid-cols-4** gap-6">
                        <div x-show="category === 'voice'" class="product-card flex flex-col bg-white border-4 border-red-100 border-dashed rounded-[2rem] p-6 h-full items-center justify-center text-center cursor-pointer hover:bg-red-50 hover:border-red-200 transition" @click="selectItem({id: 'record'})">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-3xl mb-4 shadow-sm text-red-500">🎙️</div>
                            <h3 class="text-lg font-display font-bold text-gray-800">Rekam Sendiri</h3>
                            <p class="text-xs font-bold text-red-500 mb-4 bg-red-50 px-3 py-1 rounded-full">+ Rp 75.000</p>
                            <div class="flex gap-2 w-full justify-center">
                                <button @click.stop="startRecording()" x-show="!isRecording && !audioUrl" class="bg-red-500 text-white px-4 py-2 rounded-xl text-xs font-bold shadow hover:bg-red-600 transition">REC</button>
                                <button @click.stop="stopRecording()" x-show="isRecording" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-xs font-bold animate-pulse">STOP</button>
                                <button @click.stop="speak('record')" x-show="audioUrl" class="bg-green-500 text-white px-4 py-2 rounded-xl text-xs font-bold shadow hover:bg-green-600 transition">PLAY</button>
                            </div>
                        </div>
                        <template x-for="item in filterItems(items[category === 'voice' ? 'voices' : (category === 'scent' ? 'scents' : 'gifts')])" :key="item.id">
                            <div @click="selectItem(item)" class="product-card flex flex-col bg-white rounded-[2rem] border border-orange-100 p-6 h-full cursor-pointer text-center items-center justify-center hover:shadow-lg" :class="(category === 'voice' ? selectedVoice : (category === 'scent' ? selectedScent : giftBox)) === item.id ? 'ring-1 ring-orange-200 border-orange-500' : ''">
                                <div class="text-5xl mb-4 filter drop-shadow-sm transition transform group-hover:scale-110" x-text="item.icon"></div>
                                <h3 class="text-lg font-display font-bold text-gray-800 mb-1" x-text="item.name"></h3>
                                <p class="text-xl font-display font-extrabold text-orange-600 mb-4" x-text="item.price === 0 ? 'GRATIS' : 'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                
                                <div class="flex gap-2 w-full mt-auto" x-show="category === 'voice'">
                                    <button type="button" @click.stop="speak(item.id)" x-show="item.id !== 'none'" class="flex-1 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-gray-100 text-gray-500 hover:bg-gray-200">▶️</button>
                                    <button @click="selectItem(item)" class="flex-1 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all" :class="(category === 'voice' ? selectedVoice : (category === 'scent' ? selectedScent : giftBox)) === item.id ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500 hover:bg-orange-100 hover:text-orange-600'">
                                        <span x-text="(category === 'voice' ? selectedVoice : (category === 'scent' ? selectedScent : giftBox)) === item.id ? 'TERPILIH' : 'PILIH'"></span>
                                    </button>
                                </div>
                                
                                <button @click="selectItem(item)" x-show="['scent', 'gift'].includes(category)" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all" :class="(category === 'voice' ? selectedVoice : (category === 'scent' ? selectedScent : giftBox)) === item.id ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500 hover:bg-orange-100 hover:text-orange-600'">
                                    <span x-text="(category === 'voice' ? selectedVoice : (category === 'scent' ? selectedScent : giftBox)) === item.id ? 'TERPILIH' : 'PILIH'"></span>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="category === 'gift'">
                    <div class="col-span-full mt-6 bg-white border-2 border-orange-100 rounded-[2.5rem] p-10 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2"></div>
                        <div class="flex flex-col md:flex-row gap-12 relative z-10">
                            <div class="flex-1 border-r border-orange-50 pr-8">
                                <h3 class="font-display font-extrabold text-gray-800 text-2xl mb-6 flex items-center gap-3"><span class="bg-orange-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-sm">1</span> Metode Packing</h3>
                                <div class="space-y-4">
                                    <label class="flex items-center gap-4 p-5 border-2 rounded-2xl cursor-pointer hover:border-orange-300 transition bg-white" :class="dressBear === 'true' ? 'border-orange-500 bg-orange-50/50' : 'border-gray-100'">
                                        <input type="radio" name="dress" value="true" x-model="dressBear" class="w-5 h-5 text-orange-600 focus:ring-orange-500"> 
                                        <div><span class="font-display font-bold text-gray-800 block text-lg">Dipakaikan Langsung</span><span class="text-sm text-gray-500 font-bold">Boneka dikirim rapi sudah memakai outfit.</span></div>
                                    </label>
                                    <label class="flex items-center gap-4 p-5 border-2 rounded-2xl cursor-pointer hover:border-orange-300 transition bg-white" :class="dressBear === 'false' ? 'border-orange-500 bg-orange-50/50' : 'border-gray-100'">
                                        <input type="radio" name="dress" value="false" x-model="dressBear" class="w-5 h-5 text-orange-600 focus:ring-orange-500"> 
                                        <div><span class="font-display font-bold text-gray-800 block text-lg">Bungkus Terpisah</span><span class="text-sm text-gray-500 font-bold">Outfit dibungkus terpisah di dalam kotak.</span></div>
                                    </label>
                                </div>
                            </div>
                            <div class="flex-1" x-show="giftBox !== 'none'">
                                <h3 class="font-display font-extrabold text-gray-800 text-2xl mb-6 flex items-center gap-3"><span class="bg-blue-500 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-sm">2</span> Kartu Ucapan</h3>
                                <div class="bg-yellow-50 p-6 rounded-3xl border-2 border-yellow-100 shadow-sm relative">
                                    <div class="absolute -top-3 -right-3 text-4xl transform rotate-12 filter drop-shadow-sm">💌</div>
                                    <label class="text-xs font-bold text-yellow-600 uppercase tracking-wide mb-2 block">Tulis Pesan Manis:</label>
                                    <textarea x-model="cardMessage" class="w-full h-32 bg-white border-2 border-yellow-200 rounded-2xl p-4 text-gray-700 font-bold focus:ring-2 focus:ring-orange-400 focus:border-transparent outline-none resize-none placeholder-yellow-300" placeholder="Selamat ulang tahun ya!"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </main>

        <aside class="w-[380px] bg-white border-l border-orange-100 flex flex-col z-20 shadow-[0_0_50px_rgba(0,0,0,0.05)]">
            <div class="p-6 border-b border-orange-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-display font-extrabold text-gray-800">Live Preview</h3>
                <span class="text-[10px] font-bold text-white bg-orange-400 px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">REAL-TIME</span>
            </div>
            
            <div class="flex-1 bg-orange-50/50 flex items-center justify-center p-4 relative overflow-hidden group">
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#fdba74_1px,transparent_1px)] [background-size:20px_20px]"></div>
                
                <div class="w-full h-full relative transition-all duration-300 z-10 filter drop-shadow-2xl flex items-center justify-center">
                    
                    <img :src="getBodyImg()" class="preview-layer z-0 max-w-[90%] max-h-[90%]" 
                         alt="Base Teddy"
                         onerror="this.style.opacity='0';"
                         :style="{ opacity: getBodyImg() ? '1' : '0' }">
                    
                    <img :src="getOutfitImg()" class="preview-layer z-10 max-w-[90%] max-h-[90%]" 
                         alt="Outfit"
                         :style="{ opacity: getOutfitImg() ? '1' : '0' }">
                    
                    <img :src="getAccImg()" class="preview-layer z-20 max-w-[90%] max-h-[90%]" 
                         alt="Aksesoris"
                         :style="{ opacity: getAccImg() ? '1' : '0' }">
                </div>
            </div>

            <div class="p-8 border-t border-orange-50 bg-white shadow-[0_-10px_40px_rgba(0,0,0,0.02)] z-20">
                <div class="flex justify-between items-center mb-8 bg-orange-50 p-4 rounded-2xl border border-orange-100">
                    <span class="text-gray-500 font-bold text-xs uppercase tracking-wider">Total Estimasi</span>
                    <span class="text-4xl font-display font-extrabold text-orange-600" x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
                </div>
                <form x-ref="formBuilder" action="{{ route('cart.add-custom') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="base" :value="selectedBase"><input type="hidden" name="size" :value="selectedSize"><input type="hidden" name="outfit" :value="selectedOutfit"><input type="hidden" name="accessory" :value="selectedAccessory"><input type="hidden" name="voice" :value="selectedVoice"><input type="hidden" name="scent" :value="selectedScent"><input type="hidden" name="gift_box" :value="giftBox"><input type="hidden" name="card_message" :value="cardMessage"><input type="hidden" name="dress_bear" :value="dressBear"><input type="hidden" name="action_type" x-model="actionType">
                    
                    <div class="flex gap-3">
                        <button id="btn-cart" type="button" @click="submitForm('cart')" :disabled="isSubmitting" class="flex-1 bg-white border-2 border-orange-200 text-orange-600 font-display font-bold py-4 rounded-2xl hover:bg-orange-50 hover:border-orange-400 transition flex items-center justify-center gap-2 group">
                            <span class="text-xl group-hover:scale-110 transition">👜</span>
                        </button>
                        <button id="btn-buy" type="button" @click="submitForm('buy')" :disabled="isSubmitting" class="flex-[3] bg-orange-600 text-white font-display font-bold py-4 rounded-2xl shadow-sm shadow-orange-500/20 hover:bg-orange-700 hover:shadow-md hover:-translate-y-0.5 transition transform flex items-center justify-center gap-3 text-lg">
                            <span>🛒</span> BELI SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </aside>

    </div>
</body>
</html>