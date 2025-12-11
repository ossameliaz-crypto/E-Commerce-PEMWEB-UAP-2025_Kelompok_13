<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen w-full">
        <!-- FORM KIRI -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <a href="{{ url('/') }}" class="text-5xl mb-4 block hover:scale-110 transition">🧸</a>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang!</h2>
                    <p class="mt-2 text-sm text-gray-500">Masuk untuk mulai mengadopsi boneka.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" :value="old('email')" required autofocus class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" placeholder="email@contoh.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" placeholder="••••••••">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl font-bold text-white bg-orange-600 hover:bg-orange-700 transition shadow-lg">Masuk Sekarang</button>
                </form>

                <p class="text-center text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:underline">Daftar</a></p>
            </div>
        </div>
        <!-- GAMBAR KANAN -->
        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-500 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center text-white p-12">
                <div class="text-center">
                    <span class="text-9xl block mb-6 animate-bounce">✨</span>
                    <h2 class="text-5xl font-extrabold mb-4">Build-A-Teddy</h2>
                    <p class="text-xl">Bikin boneka impianmu sekarang.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>