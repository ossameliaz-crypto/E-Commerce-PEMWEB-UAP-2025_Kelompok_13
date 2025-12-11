<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { orange: { 50: '#fff7ed', 600: '#ea580c' } } } } }
    </script>
</head>
<body class="text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-4xl">🚚</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">TRACK ORDER</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Lacak Paketmu</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali ke Beranda</a>
    </nav>

    <div class="flex-1 flex items-center justify-center p-6 bg-orange-50/50">
        <div class="w-full max-w-2xl bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl border-t-8 border-orange-600/80 text-center transform hover:scale-[1.01] transition duration-300">
            <span class="text-6xl mb-6 block animate-bounce">📦</span>
            <h1 class="text-4xl font-display font-extrabold text-gray-900 mb-4">Di Mana Teddy-ku?</h1>
            <p class="text-lg text-gray-600 mb-10 font-medium">Masukkan nomor resi atau Order ID untuk melihat status pengiriman.</p>
            
            <form action="{{ route('history') }}" method="GET" class="space-y-6">
                <input 
                    type="text" 
                    name="resi_id"
                    placeholder="Masukkan No. Resi atau Order ID (Contoh: TRX-88291)" 
                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-orange-200 outline-none text-gray-700 font-bold placeholder-gray-400 transition focus:ring-4 focus:ring-orange-100"
                >
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-orange-700 transition shadow-lg transform hover:-translate-y-0.5"
                >
                    <span class="text-xl">🔍</span> Cek Status Pengiriman
                </button>
            </form>

            <div class="mt-8 flex justify-center gap-6 text-sm font-bold text-gray-500">
                <span class="flex items-center gap-2"><span class="text-green-500">✅</span> Lacak Real-time</span>
                <span class="flex items-center gap-2"><span class="text-blue-500">🛡️</span> Garansi Pengiriman 100%</span>
            </div>
        </div>
    </div>

</body>
</html>