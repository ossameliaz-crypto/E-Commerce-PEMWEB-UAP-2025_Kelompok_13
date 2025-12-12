<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Design Alignment */
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
        
        /* Custom Colors */
        .shadow-xl-orange {
            box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.2), 0 4px 6px -2px rgba(234, 88, 12, 0.05);
        }
        .focus-orange:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.3);
        }
    </style>
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        orange: { 50: '#fff7ed', 100: '#ffedd5', 500: '#f97316', 600: '#ea580c' },
                        gray: { 800: '#1F2937', 900: '#111827' }
                    } 
                } 
            } 
        }
    </script>
</head>
<body class="text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-md px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-3xl">🧸</span>
            <span class="font-display font-extrabold text-gray-800 text-2xl">Build-A-Teddy</span>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">← Kembali</a>
    </nav>

    <div class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-4xl rounded-[3rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-orange-50">
            
            <div class="bg-orange-600 text-white p-10 md:w-2/5 flex flex-col justify-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 -translate-y-10"></div>
                
                <h2 class="text-3xl font-display font-bold mb-6 relative z-10">Pusat Bantuan Cepat 💌</h2>
                <p class="mb-8 opacity-90 relative z-10">Tim Teddy Care siap membantumu setiap hari kerja.</p>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">🏢</div>
                        <p class="font-bold">Kantor Pusat Malang</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">📱</div>
                        <p class="font-bold">Telp: (0341) 577-911</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">📧</div>
                        <p class="font-bold">help@buildateddy.id</p>
                    </div>
                </div>
            </div>

            <div class="p-10 md:w-3/5">
                <form action="#" method="GET" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Nama Kamu</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus-orange focus:bg-white focus:ring-0 outline-none transition" placeholder="Contoh: Ossa/Shelfina">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Email</label>
                        <input type="email" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus-orange focus:bg-white focus:ring-0 outline-none transition" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Pesan / Pertanyaan</label>
                        <textarea rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus-orange focus:bg-white focus:ring-0 outline-none transition resize-none" placeholder="Tulis pesanmu disini..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-4 rounded-xl hover:bg-orange-700 transition transform active:scale-95 shadow-lg shadow-orange-500/50">
                        Kirim Pesan 🚀
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>