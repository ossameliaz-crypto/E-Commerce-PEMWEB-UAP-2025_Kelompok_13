<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        
        <!-- LEFT: IMAGE (Hidden on Mobile) -->
        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-bl from-orange-400 to-yellow-500 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-10 text-white relative z-10">
                    <span class="text-9xl block mb-6 drop-shadow-lg">✨</span>
                    <h2 class="text-4xl font-extrabold mb-4">Gabung Sekarang</h2>
                    <p class="text-orange-100 text-lg max-w-md mx-auto">Dapatkan akses ke ribuan aksesoris lucu dan mulai koleksi bonekamu.</p>
                </div>
            </div>
             <!-- Decorative Circles -->
             <div class="absolute top-0 left-0 -ml-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-10"></div>
             <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 rounded-full bg-white opacity-10"></div>
        </div>

        <!-- RIGHT: FORM -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h2>
                    <p class="mt-2 text-sm text-gray-500">Isi data diri kamu untuk memulai.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                            class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold" 
                            placeholder="Contoh: Ossa P.">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required 
                            class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold" 
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold" 
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                            class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold" 
                            placeholder="Ulangi password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:-translate-y-1 transition duration-200">
                            ✨ Daftar Sekarang
                        </button>
                    </div>
                </form>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:text-orange-500">Login disini</a>
                </p>
            </div>
        </div>

    </div>
</x-guest-layout>