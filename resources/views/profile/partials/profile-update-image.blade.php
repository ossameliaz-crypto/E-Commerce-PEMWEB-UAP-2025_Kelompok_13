<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ Auth::user()->role === 'seller' ? __('Update Logo Toko') : __('Update Foto Profil') }} 
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ Auth::user()->role === 'seller' ? __('Perbarui logo toko/perusahaan Anda.') : __('Perbarui foto profil Anda.') }}
        </p>
    </header>

    {{-- 🌟 BAGIAN AVATAR/INISIAL 🌟 --}}
    @php
        $user = Auth::user();
        $name = $user->name ?? 'User';
        $initial = strtoupper(substr($name, 0, 1)); 
        
        // Menggunakan nama kolom database yang BENAR: 'profile_picture'
        $imageUrl = $user->profile_picture ?? null; 
        
        // Logika Warna Inisial (untuk konsistensi)
        $colorClasses = ['bg-red-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500', 'bg-indigo-500', 'bg-pink-500', 'bg-purple-500'];
        $colorKey = ord($initial) % count($colorClasses);
        $color = $colorClasses[$colorKey];
    @endphp

    <div class="mb-6">
        @if ($imageUrl)
            {{-- Tampilkan Foto Profil (Path harus sesuai dengan yang disimpan di Controller) --}}
            <img src="{{ asset($imageUrl) }}" alt="{{ $name }}" 
                 class="h-24 w-24 rounded-full object-cover border-4 border-gray-100 shadow-md">
        @else
            {{-- Tampilkan Inisial Nama --}}
            <span class="h-24 w-24 rounded-full flex items-center justify-center text-4xl font-bold text-white {{ $color }} border-4 border-gray-100 shadow-md">
                {{ $initial }}
            </span>
        @endif
    </div>
    {{-- ----------------------------- --}}

    <form method="post" action="{{ route('profile.update-image') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch') 
        
        <div>
            <x-input-label for="image_file" :value="__('Pilih File Gambar Baru')" class="mt-4 text-gray-700 font-bold" />
            
            <input 
                id="image_file" 
                name="image_file" 
                type="file" 
                {{-- Gaya input diubah agar konsisten dengan input lain --}}
                class="mt-1 block w-full px-5 py-3 border rounded-xl bg-gray-50 border-gray-200 text-gray-900 focus:ring-2 focus:ring-orange-500 outline-none" 
                required 
            />
            <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
        </div>

        <div class="flex items-center gap-4">
            {{-- 🚀 PERBAIKAN FINAL: Tombol SAVE yang SAMA ukurannya dengan tombol DELETE ACCOUNT --}}
            <button type="submit" class="inline-flex items-center px-5 py-3 bg-orange-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-normal hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('SAVE') }}
            </button>
        </div>
        
        {{-- Notifikasi Sukses --}}
        @if (session('status') === 'image-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600"
            >{{ __('Foto/Logo berhasil diperbarui.') }}</p>
        @endif
    </form>
</section>