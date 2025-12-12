<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
        
        .color-yellow-bg { background-color: #FFECC5; }
        .color-orange-bg { background-color: #FFEDD5; }
        .color-darker-orange-bg { background-color: #FFD4AA;  }

        .vision-card {
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
            border: 4px solid white;
        }
        .vision-card:hover {
            transform: scale(1.05) rotate(-0.5deg);
            box-shadow: 0 15px 30px -5px rgba(234, 88, 12, 0.35);
            border-color: #FFEDD5; 
        }
        .vision-card:hover .vision-icon {
            transform: scale(1.1);
        }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { orange: { 50: '#fff7ed', 100: '#ffedd5', 500: '#f97316', 600: '#ea580c', 700: '#c2410c' } } } } }
    </script>
</head>
<body class="text-gray-800">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-lg px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-4xl group-hover:rotate-6 transition">🧸</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">BUILD-A-TEDDY</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Our Mission</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold px-4 py-2 rounded-full hover:bg-orange-50 transition">Kembali ke Beranda</a>
    </nav>

    <div class="relative py-24 overflow-hidden bg-orange-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="bg-white text-orange-600 font-extrabold tracking-widest uppercase text-sm mb-4 inline-block px-4 py-1.5 rounded-full shadow-md border border-orange-200">The Official Store</span>
            <h1 class="text-5xl md:text-6xl font-display font-extrabold text-gray-900 mb-6 leading-tight">Menciptakan Kebahagiaan <br><span class="text-orange-600">Satu Pelukan Sekali</span></h1>
            <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed font-medium">
                Build-A-Teddy adalah merek global yang fokus memberikan nilai lebih bagi kehidupan melalui boneka yang dibuat khusus dan personal.
            </p>
        </div>
        <div class="absolute top-0 left-0 w-80 h-80 bg-orange-200 opacity-20 rounded-full mix-blend-multiply filter blur-3xl -translate-x-1/3 -translate-y-1/4"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-orange-300 opacity-20 rounded-full mix-blend-multiply filter blur-3xl translate-x-1/3 translate-y-1/4"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 pb-24 pt-20">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
            <div class="bg-white p-3 rounded-[3rem] shadow-2xl border-4 border-orange-100 hover:rotate-1 transition duration-500 hover:scale-[1.02]">
                <img src="{{ asset('picture/ourPhoto.jpeg') }}" class="rounded-[2.5rem] w-full shadow-lg" alt="Tim Kami Bekerja">
            </div>
            <div class="space-y-6">
                <h2 class="text-4xl font-display font-extrabold text-orange-600 mb-2">Filosofi Kualitas</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Kami percaya bahwa setiap boneka harus memiliki cerita dan kenangan. Melalui platform Workshop interaktif, pelanggan kami menjadi desainer, menentukan karakter, pakaian, dan bahkan suara teman baru mereka.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Kami berkomitmen pada kualitas material premium, etika produksi, dan selalu berinovasi untuk memberikan pengalaman personalisasi terbaik di pasar e-commerce.
                </p>
            </div>
        </div>

        <h2 class="text-3xl font-display font-extrabold text-gray-900 text-center mb-12">Nilai Utama Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mb-20">
            
            <div class="vision-card p-10 rounded-[2rem] color-yellow-bg border-4 border-white">
                <div class="text-6xl mb-4 vision-icon text-gray-700">🏭</div>
                <h3 class="font-display font-extrabold text-xl mb-2 text-orange-700">Global Quality</h3>
                <p class="text-sm text-gray-700 font-medium">Standar kualitas boneka yang diakui secara internasional.</p>
            </div>
            
            <div class="vision-card p-10 rounded-[2rem] color-orange-bg border-4 border-white">
                <div class="text-6xl mb-4 vision-icon text-gray-700">💡</div>
                <h3 class="font-display font-extrabold text-xl mb-2 text-orange-700">Inovasi Digital</h3>
                <p class="text-sm text-gray-700 font-medium">Workshop 3D dan fitur rekam suara canggih.</p>
            </div>
            
            <div class="vision-card p-10 rounded-[2rem] color-darker-orange-bg border-4 border-white">
                <div class="text-6xl mb-4 vision-icon text-gray-700">🤝</div>
                <h3 class="font-display font-extrabold text-xl mb-2 text-orange-700">Dukungan Kreator</h3>
                <p class="text-sm text-gray-700 font-medium">Platform untuk desainer lokal menjual karya unik mereka.</p>
            </div>
        </div>
        
        <div class="text-center pt-10 border-t border-orange-100">
            <h2 class="text-3xl font-display font-extrabold text-gray-900 mb-8">Meet the Visionaries</h2>
            <div class="flex justify-center gap-12">
                
                <div class="max-w-xs p-6 rounded-3xl bg-white shadow-xl border border-orange-100 hover:shadow-2xl transition">
                    <div class="w-28 h-28 mx-auto bg-orange-100 rounded-full flex items-center justify-center text-5xl mb-4 shadow-inner border-4 border-white">👩🏻‍💻</div>
                    <h3 class="font-bold text-xl mb-1 font-display">Ossa Amelia Zuhra Lubis</h3>
                    <p class="text-sm text-gray-500 font-medium">Chief Technology Officer (CTO)</p>
                </div>

                <div class="max-w-xs p-6 rounded-3xl bg-white shadow-xl border border-orange-100 hover:shadow-2xl transition">
                    <div class="w-28 h-28 mx-auto bg-pink-100 rounded-full flex items-center justify-center text-5xl mb-4 shadow-inner border-4 border-white">👩🏻‍🎨</div>
                    <h3 class="font-bold text-xl mb-1 font-display">Shelfina Khayla Anindita</h3>
                    <p class="text-sm text-gray-500 font-medium">Chief Creative Officer (CCO)</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-orange-100 py-8 text-center">
        <p class="text-gray-400 text-sm font-bold">
            © 2025 Build-A-Teddy Official Store. All Rights Reserved.
            <br><span class="text-[10px] text-gray-300 mt-1">Dikembangkan di Malang, Indonesia.</span>
        </p>
    </footer>

</body>
</html>