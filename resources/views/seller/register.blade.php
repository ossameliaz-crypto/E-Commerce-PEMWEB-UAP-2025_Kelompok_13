<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Seller - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-orange-50/50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-orange-100">
        
        <div class="md:w-1/2 bg-gradient-to-br from-orange-500 to-red-600 p-12 text-white flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <span class="text-7xl mb-6 block drop-shadow-md">🧸</span>
                <h2 class="text-4xl font-extrabold mb-4 leading-tight">Mulai Bisnis<br>Bonekamu!</h2>
                <p class="text-orange-100 text-lg opacity-90">Gabung komunitas kreator dan jual karya unikmu ke ribuan mahasiswa.</p>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
        </div>

        <div class="md:w-1/2 p-12">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-extrabold text-gray-800">Form Buka Toko</h3>
                <a href="{{ url('/') }}" class="text-sm font-bold text-gray-400 hover:text-orange-600 transition">Batal</a>
            </div>

            {{-- PESAN STATUS (Success/Error dari Controller) --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- FORM SUBMIT --}}
            <form action="{{ route('store.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Nama Toko (name) --}}
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="name">Nama Toko</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Teddy House Malang" required
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tentang Toko (about) --}}
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="about">Tentang Toko</label>
                    {{-- KOREKSI: Name diubah ke 'about' --}}
                    <textarea name="about" id="about" rows="3" placeholder="Ceritakan keunikan tokomu..." 
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('about') border-red-500 @enderror">{{ old('about') }}</textarea>
                    @error('about')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Telepon (phone) --}}
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="phone">Nomor Telepon Toko</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="081xxxxxxxx"
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KOREKSI: PENAMBAHAN FIELD ALAMAT --}}
                <h4 class="text-base font-bold text-gray-700 mt-8 mb-4 border-b border-gray-200 pb-1">Detail Alamat Toko</h4>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    {{-- Kota (city) --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="city">Kota</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="Contoh: Malang" 
                            class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('city') border-red-500 @enderror">
                        @error('city')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Kode Pos (postal_code) --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="postal_code">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="65141" 
                            class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Alamat Lengkap (address) --}}
                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="address">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" placeholder="Nama jalan, nomor, patokan..." 
                        class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition font-semibold @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Akhir Penambahan Field Alamat --}}


                {{-- Logo Toko (logo) --}}
                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1" for="logo">Logo Toko</label>
                    <div class="relative w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group @error('logo') border-red-500 @enderror">
                        <span class="text-3xl text-gray-300 group-hover:text-orange-400 transition mb-2">📁</span>
                        <p class="text-sm text-gray-400 group-hover:text-orange-500" id="file-name">Klik untuk upload logo (Opsional)</p>
                        <input type="file" name="logo" id="logo" class="absolute inset-0 opacity-0 cursor-pointer" 
                            onchange="document.getElementById('file-name').textContent = this.files.length > 0 ? this.files[0].name : 'Klik untuk upload logo (Opsional)'"/>
                    </div>
                    @error('logo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-orange-600 text-white font-bold py-4 rounded-2xl hover:bg-orange-700 transition shadow-lg transform hover:-translate-y-1">
                    🚀 Buka Toko Sekarang
                </button>
            </form>
        </div>
    </div>

</body>
</html>