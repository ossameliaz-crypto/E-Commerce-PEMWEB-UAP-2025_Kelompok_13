<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Seller - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-orange-50/50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-orange-100">
        
        <!-- LEFT: ILLUSTRATION -->
        <div class="md:w-1/2 bg-gradient-to-br from-orange-500 to-red-600 p-12 text-white flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <span class="text-7xl mb-6 block drop-shadow-md">🏪</span>
                <h2 class="text-4xl font-extrabold mb-4 leading-tight">Mulai Bisnis<br>Bonekamu!</h2>
                <p class="text-orange-100 text-lg opacity-90">Gabung komunitas kreator dan jual karya unikmu ke ribuan mahasiswa.</p>
            </div>
            <!-- Circles -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
        </div>

        <!-- RIGHT: FORM -->
        <div class="md:w-1/2 p-12">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-extrabold text-gray-800">Form Buka Toko</h3>
                <a href="{{ url('/') }}" class="text-sm font-bold text-gray-400 hover:text-orange-600 transition">Batal</a>
            </div>

            <form action="{{ route('store.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Nama Toko</label>
                    <input type="text" name="name" placeholder="Contoh: Teddy House Malang" required
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Tentang Toko</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan keunikan tokomu..." required
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold"></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Logo Toko</label>
                    <div class="relative w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group">
                        <span class="text-3xl text-gray-300 group-hover:text-orange-400 transition mb-2">📁</span>
                        <p class="text-sm text-gray-400 group-hover:text-orange-500">Klik untuk upload logo</p>
                        <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer" />
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-orange-600 transition shadow-lg transform hover:-translate-y-1">
                    🚀 Buka Toko Sekarang
                </button>
            </form>
        </div>
    </div>

</body>
</html>