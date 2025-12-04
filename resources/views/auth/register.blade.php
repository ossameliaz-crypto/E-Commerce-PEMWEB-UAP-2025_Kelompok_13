<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen w-full">
        
        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-bl from-orange-400 to-yellow-500 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-12 text-white relative z-10">
                    <span class="text-9xl block mb-6 drop-shadow-xl">✨</span>
                    <h2 class="text-5xl font-extrabold mb-6 tracking-tight">Gabung Sekarang</h2>
                    <p class="text-orange-100 text-xl max-w-md mx-auto leading-relaxed">Dapatkan akses ke ribuan aksesoris lucu dan mulai koleksi bonekamu hari ini.</p>
                </div>
            </div>
             <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-10 blur-3xl"></div>
             <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 rounded-full bg-white opacity-10 blur-2xl"></div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12 bg-white">
            <div class="w-full max-w-md space-y-6">
                
                <div class="text-center md:text-left mb-8">
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h2>
                    <p class="mt-2 text-base text-gray-500">Isi data diri kamu untuk memulai.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                            class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold outline-none" 
                            placeholder="Contoh: Ossa P.">
                        @error('name') <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required 
                            class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold outline-none" 
                            placeholder="nama@email.com">
                        @error('email') <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold outline-none" 
                            placeholder="Minimal 8 karakter">
                        @error('password') <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                            class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition font-semibold outline-none" 
                            placeholder="Ulangi password">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-orange-500/30 text-base font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:-translate-y-1 transition duration-200">
                            ✨ Daftar Sekarang
                        </button>
                    </div>
                </form>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:text-orange-500 transition">Login disini</a>
                </p>
            </div>
        </div>

    </div>
</body>
</html>