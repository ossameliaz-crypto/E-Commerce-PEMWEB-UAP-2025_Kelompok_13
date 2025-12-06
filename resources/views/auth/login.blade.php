<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Build-A-Teddy</title>
    <!-- PENTING: Pakai CDN ini biar ga error Vite -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-white">
    <!-- Layout Split Screen -->
    <div class="flex min-h-screen w-full">
        <!-- KIRI: FORM -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <a href="{{ url('/') }}" class="text-5xl mb-4 block">🧸</a>
                    <h2 class="text-4xl font-extrabold text-gray-900">Selamat Datang!</h2>
                    <p class="mt-2 text-gray-500">Masuk untuk mulai mengadopsi boneka.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full px-5 py-4 bg-gray-50 border rounded-2xl outline-none focus:ring-2 focus:ring-orange-500" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-4 bg-gray-50 border rounded-2xl outline-none focus:ring-2 focus:ring-orange-500" placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-white bg-orange-600 hover:bg-orange-700 transition shadow-lg">
                        🚀 Masuk Sekarang
                    </button>
                </form>
                <p class="text-center text-sm">Belum punya akun? <a href="{{ route('register') }}" class="text-orange-600 font-bold">Daftar</a></p>
            </div>
        </div>
        <!-- KANAN: GAMBAR -->
        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center text-center p-12">
                <div>
                    <span class="text-9xl block mb-6 animate-bounce">🧸</span>
                    <h2 class="text-5xl font-extrabold text-orange-800">Build-A-Teddy</h2>
                </div>
            </div>
        </div>
    </div>
</body>
</html>