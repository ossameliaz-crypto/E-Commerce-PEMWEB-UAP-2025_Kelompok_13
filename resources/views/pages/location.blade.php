<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Store - Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { orange: { 600: '#ea580c' } } } } }
    </script>
</head>
<body class="text-gray-800">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-4xl">📍</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">LOKASI STORE</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Visit Us</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali</a>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-12 flex flex-col md:flex-row gap-10">
        
        <div class="md:w-1/3 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-orange-100">
                <h2 class="text-2xl font-display font-bold text-gray-800 mb-6">Build-A-Teddy Malang</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <span class="text-2xl">🏠</span>
                        <div>
                            <p class="font-bold text-gray-700">Alamat:</p>
                            <p class="text-gray-600 text-sm">Jl. Ijen Besar No. 88<br>Klojen, Kota Malang<br>Jawa Timur, 65119</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="text-2xl">⏰</span>
                        <div>
                            <p class="font-bold text-gray-700">Jam Operasional:</p>
                            <p class="text-gray-600 text-sm">Senin - Jumat: 10.00 - 21.00 WIB<br>Sabtu - Minggu: 09.00 - 22.00 WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="text-2xl">📞</span>
                        <div>
                            <p class="font-bold text-gray-700">Telepon:</p>
                            <p class="text-gray-600 text-sm">(0341) 555-TEDDY</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <button class="w-full bg-orange-600 text-white font-bold py-3 rounded-xl shadow-md hover:bg-orange-700 transition">
                        Petunjuk Arah (Google Maps)
                    </button>
                </div>
            </div>
        </div>

        <div class="md:w-2/3 h-[500px] bg-gray-200 rounded-[2.5rem] overflow-hidden shadow-inner relative group border-4 border-white">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.448906371767!2d112.6175!3d-7.975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNTgnMzAuMCJTIDExMsKwMzcnMDMuMCJF!5e0!3m2!1sen!2sid!4v1600000000000!5m2!1sen!2sid" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" class="grayscale group-hover:grayscale-0 transition duration-500">
            </iframe>
            
            <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur px-6 py-3 rounded-2xl shadow-lg">
                <p class="font-bold text-orange-600">📍 Malang Flagship Store</p>
            </div>
        </div>

    </div>

</body>
</html>