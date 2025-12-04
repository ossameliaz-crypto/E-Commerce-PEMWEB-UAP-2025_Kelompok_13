<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        
        <!-- LEFT: FORM -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <a href="{{ url('/') }}" class="inline-block text-5xl mb-4 hover:animate-bounce cursor-pointer">🧸</a>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang!</h2>
                    <p class="mt-2 text-sm text-gray-500">Masuk untuk mulai mengadopsi boneka impianmu.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Alamat Email</label>
                        <div class="mt-1 relative rounded-2xl shadow-sm">
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold placeholder-gray-300" 
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 ml-1 mb-2">Password</label>
                        <div class="mt-1 relative rounded-2xl shadow-sm">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full px-5 py-4 bg-gray-50 border-gray-200 rounded-2xl text-gray-900 focus:ring-orange-500 focus:border-orange-500 transition font-semibold placeholder-gray-300" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-bold text-orange-600 hover:text-orange-500">Lupa password?</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:-translate-y-1 transition duration-200">
                            🚀 Masuk Sekarang
                        </button>
                    </div>
                </form>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:text-orange-500">Daftar gratis</a>
                </p>
            </div>
        </div>

        <!-- RIGHT: IMAGE (Hidden on Mobile) -->
        <div class="hidden md:block md:w-1/2 bg-orange-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-500 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-10 text-white relative z-10">
                    <span class="text-9xl block mb-6 drop-shadow-lg">🧸</span>
                    <h2 class="text-4xl font-extrabold mb-4">Build-A-Teddy</h2>
                    <p class="text-orange-100 text-lg max-w-md mx-auto">Platform kreasi boneka custom nomor satu untuk mahasiswa kreatif.</p>
                </div>
            </div>
            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-white opacity-10"></div>
        </div>

    </div>
</x-guest-layout>