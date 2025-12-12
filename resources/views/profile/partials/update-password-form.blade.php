<section class="space-y-6">
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

        {{-- CURRENT PASSWORD --}}
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" class="text-gray-900 font-bold" />
            
            <x-text-input 
                id="current_password" 
                name="current_password" 
                type="password" 
                {{-- Gaya input diatur agar terang dan sesuai standar --}}
                class="mt-1 block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-orange-500 outline-none" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- NEW PASSWORD --}}
        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-gray-900 font-bold" />
            
            <x-text-input 
                id="password" 
                name="password" 
                type="password" 
                {{-- Gaya input diatur agar terang dan sesuai standar --}}
                class="mt-1 block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-orange-500 outline-none" 
                autocomplete="new-password" 
            />
            
            <p class="mt-1 text-sm text-gray-600">{{ __('Minimal 8 karakter.') }}</p>
            
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-900 font-bold" />
            
            <x-text-input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                {{-- Gaya input diatur agar terang dan sesuai standar --}}
                class="mt-1 block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-orange-500 outline-none" 
                autocomplete="new-password" 
            />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            {{-- 🚀 Tombol SAVE sudah menggunakan style besar (px-5 py-3 rounded-xl) --}}
            <button type="submit" class="inline-flex items-center px-5 py-3 bg-orange-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-normal hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('SAVE') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>