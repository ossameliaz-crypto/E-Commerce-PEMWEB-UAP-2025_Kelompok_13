<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ & Bantuan - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { orange: { 50: '#fff7ed', 600: '#ea580c' } } } } }
    </script>
</head>
<body class="text-gray-800">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-4xl">💡</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">FAQ CENTER</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tanya Jawab Populer</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali</a>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-extrabold text-gray-900 mb-4">Punya Pertanyaan? Kami Punya Jawabannya!</h1>
            <p class="text-lg text-gray-500">Temukan solusi cepat untuk masalah umum seputar produk, pengiriman, dan kustomisasi.</p>
        </div>

        <div class="space-y-6">
            <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-lg border border-orange-100 hover:border-orange-200 transition">
                <button @click="open = !open" class="flex justify-between items-center w-full p-6 text-left focus:outline-none">
                    <span class="text-xl font-bold font-display text-gray-800">Bagaimana cara kerja Workshop kustomisasi?</span>
                    <span class="text-2xl text-orange-600 transform transition duration-300" :class="{ 'rotate-180': open }">⬇️</span>
                </button>
                <div x-show="open" x-collapse.duration.500ms class="px-6 pb-6 text-gray-600 border-t border-gray-100">
                    <p class="leading-relaxed pt-4">
                        Di Workshop, Anda mulai dengan memilih base-body boneka (beruang, kelinci, dll.). Kemudian Anda bisa menambahkan outfit, aksesoris, merekam suara, dan memilih wangi. Setiap item kustomisasi akan ditampilkan secara real-time di layar Anda. Setelah selesai, produk akan dirakit oleh tim ahli kami!
                    </p>
                </div>
            </div>

            <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-lg border border-orange-100 hover:border-orange-200 transition">
                <button @click="open = !open" class="flex justify-between items-center w-full p-6 text-left focus:outline-none">
                    <span class="text-xl font-bold font-display text-gray-800">Apakah boneka aman untuk anak-anak?</span>
                    <span class="text-2xl text-orange-600 transform transition duration-300" :class="{ 'rotate-180': open }">⬇️</span>
                </button>
                <div x-show="open" x-collapse.duration.500ms class="px-6 pb-6 text-gray-600 border-t border-gray-100">
                    <p class="leading-relaxed pt-4">
                        Ya, tentu! Semua boneka kami terbuat dari bahan hypoallergenic premium, bebas bahan kimia berbahaya, dan telah lulus standar SNI (Standar Nasional Indonesia). Boneka aman untuk anak usia 3 tahun ke atas.
                    </p>
                </div>
            </div>
            
            <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-lg border border-orange-100 hover:border-orange-200 transition">
                <button @click="open = !open" class="flex justify-between items-center w-full p-6 text-left focus:outline-none">
                    <span class="text-xl font-bold font-display text-gray-800">Berapa lama proses pengiriman?</span>
                    <span class="text-2xl text-orange-600 transform transition duration-300" :class="{ 'rotate-180': open }">⬇️</span>
                </button>
                <div x-show="open" x-collapse.duration.500ms class="px-6 pb-6 text-gray-600 border-t border-gray-100">
                    <p class="leading-relaxed pt-4">
                        Proses perakitan dan *quality check* memerlukan waktu 1 hari kerja. Pengiriman reguler (JNE/J&T) memakan waktu 3-5 hari ke seluruh Indonesia. Anda bisa melacaknya di halaman **Lacak Pesanan**.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center bg-orange-100 p-8 rounded-3xl border border-orange-200">
            <h3 class="text-xl font-display font-extrabold text-orange-700 mb-4">Tidak Menemukan Jawaban?</h3>
            <p class="text-gray-600 mb-6">Jangan khawatir, hubungi tim support kami secara langsung.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-orange-600 text-white font-bold px-8 py-3 rounded-xl shadow-md hover:bg-orange-700 transition transform hover:-translate-y-0.5">
                Hubungi Kami Sekarang
            </a>
        </div>
    </div>

</body>
</html>