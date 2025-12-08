<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put') 

        {{-- 1. CURRENT PASSWORD --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="current-password" 
            />
            {{-- Error hanya untuk current password yang salah --}}
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- 2. NEW PASSWORD (Titik Fokus Error: Different dan Min Length) --}}
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="new-password" 
            />
            
            {{-- Tambahkan instruksi minimal 8 karakter --}}
            <p class="mt-1 text-xs text-gray-500">
                {{ __('Minimal 8 karakter.') }}
            </p>

            {{-- Menampilkan Error: 1. Harus beda, 2. Minimal length, 3. Konfirmasi, dll. --}}
            {{-- Laravel akan menampilkan pesan yang relevan (e.g., "The password field must be at least 8 characters.") --}}
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            
            {{-- PESAN SPESIFIK UNTUK "DIFFERENT" (Optional, jika pesan Laravel kurang jelas) 🌟 --}}
            @if ($errors->updatePassword->has('password') && str_contains($errors->updatePassword->first('password'), 'must be different'))
                <p class="mt-2 text-sm text-red-600">
                    {{ __('Password baru tidak boleh sama dengan password yang sedang digunakan.') }}
                </p>
            @endif

        </div>

        {{-- 3. CONFIRM PASSWORD --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" /> 
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>