<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil akun Anda, alamat email, dan nomor telepon.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            {{-- Bagian verifikasi email diabaikan untuk fokus utama --}}
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
            
            {{-- Mengambil nilai tersimpan dari database: $user->phone_number --}}
            <x-text-input 
                id="phone_number" 
                name="phone_number" 
                type="text" 
                class="mt-1 block w-full" 
                :value="old('phone_number', $user->phone_number)" 
                required 
                autocomplete="tel" 
                placeholder="Contoh: 081234567890" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>
        
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>