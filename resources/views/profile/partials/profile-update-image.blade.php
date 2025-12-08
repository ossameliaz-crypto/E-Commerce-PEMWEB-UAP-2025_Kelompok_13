<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ Auth::user()->role === 'seller' ? __('Update Logo Toko') : __('Update Foto Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ Auth::user()->role === 'seller' ? __('Perbarui logo toko/perusahaan Anda.') : __('Perbarui foto profil akun Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-image') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @php
            $user = Auth::user();
            // KOLOM TUNGGAL: Selalu gunakan profile_picture
            $uploadedPath = $user->profile_picture; 
            $imagePath = $uploadedPath ? asset('storage/' . $uploadedPath) : null;
            $initial = strtoupper(substr($user->name, 0, 1));
            
            // Logika warna dinamis untuk placeholder
            $colors = ['bg-blue-500', 'bg-yellow-500', 'bg-indigo-500', 'bg-pink-500', 'bg-purple-500', 'bg-orange-500'];
            if ($user->role === 'seller') {
                $bgColor = 'bg-green-500';
            } elseif ($user->role === 'admin') {
                $bgColor = 'bg-red-500';
            } else {
                $hashValue = crc32($user->name);
                $colorIndex = abs($hashValue) % count($colors);
                $bgColor = $colors[$colorIndex];
            }
        @endphp

        <div class="flex items-center gap-4">
            @if($imagePath)
                <img src="{{ $imagePath }}" 
                     alt="{{ $user->role === 'seller' ? 'Logo' : 'Foto Profil' }}" 
                     class="rounded-full h-20 w-20 object-cover border-2 border-gray-300">
            @else
                <div class="h-20 w-20 rounded-full {{ $bgColor }} flex items-center justify-center text-white font-bold text-3xl border-2 border-gray-300">
                    {{ $initial }}
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="image_file" :value="Auth::user()->role === 'seller' ? __('Pilih Logo Baru') : __('Pilih Foto Baru')" />
            
            <input id="image_file" name="image_file" type="file" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required autofocus autocomplete="image_file" />
            <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'image-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>