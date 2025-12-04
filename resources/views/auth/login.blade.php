<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen w-full">
        
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <div class="text-center md:text-left">
                    <a href="{{ url('/') }}" class="inline-block text-5xl mb-4 hover:animate-bounce cursor-pointer no-underline">🧸</a>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Selamat Datang!</h2>
                    <p class="mt-2 text-base text-gray-500">Masuk untuk mulai mengadopsi boneka impianmu.</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Alamat Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold placeholder-gray-400 outline-none" 
                                placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold placeholder-gray-400 outline-none" 
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-bold text-orange-600 hover:text-orange-500 transition">Lupa password?</a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-orange-500/30 text-base font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:-translate-y-1 transition duration-200">
                        🚀 Masuk Sekarang
                    </button>
                </form>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:text-orange-500 transition">Daftar gratis</a>
                </p>
            </div>
        </div>

        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-500 opacity-90"></div>
            
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-12 text-white relative z-10">
                    <span class="text-9xl block mb-6 drop-shadow-xl animate-pulse">🧸</span>
                    <h2 class="text-5xl font-extrabold mb-6 tracking-tight">Build-A-Teddy</h2>
                    <p class="text-orange-100 text-xl max-w-md mx-auto leading-relaxed">Platform kreasi boneka custom nomor satu untuk mahasiswa kreatif.</p>
                </div>
            </div>
            
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-white opacity-10 blur-2xl"></div>
        </div>

    </div>
</body>
</html>