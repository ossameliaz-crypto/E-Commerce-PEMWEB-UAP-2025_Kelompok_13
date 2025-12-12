<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 rounded-xl bg-red-100 text-red-700 font-medium">
                    {{ session('error') }}
                </div>
            @endif
            {{-- ------------------------------------------------------------- --}}

            <div class="mb-4 text-sm font-medium text-gray-600">
                <a href="{{ route('seller.dashboard') }}" class="text-orange-500 hover:text-orange-600">Seller Panel</a> /
                <span>Tambah Produk</span>
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                
                <h3 class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-4">
                    Formulir Produk Baru
                </h3>

                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" id="name" name="name" 
                                value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('name') border-red-500 @enderror" 
                                placeholder="Contoh: Kaos Merah UAP" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="product_category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="product_category_id" name="product_category_id" 
                                 class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('product_category_id') border-red-500 @enderror" 
                                 required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea id="description" name="description" rows="4" 
                                     class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('description') border-red-500 @enderror" 
                                     placeholder="Jelaskan produk Anda secara detail..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Kondisi Produk</label>
                            <select id="condition" name="condition" 
                                         class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('condition') border-red-500 @enderror" 
                                         required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru (New)</option>
                                <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>Bekas (Second)</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat (gram)</label>
                            <input type="number" id="weight" name="weight" 
                                         value="{{ old('weight') }}"
                                         min="1"
                                         class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('weight') border-red-500 @enderror" 
                                         placeholder="Contoh: 500 (gram)" required>
                            @error('weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" id="price" name="price" 
                                         value="{{ old('price') }}"
                                         min="1000" step="1000"
                                         class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('price') border-red-500 @enderror" 
                                         placeholder="Contoh: 75000" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok Gudang (pcs)</label>
                            <input type="number" id="stock" name="stock" 
                                         value="{{ old('stock') }}"
                                         min="1"
                                         class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('stock') border-red-500 @enderror" 
                                         placeholder="Contoh: 120" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        <input type="file" id="image" name="image" accept="image/*"
                                 class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border-gray-300 rounded-xl shadow-sm @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maksimal 2MB (jpeg, png, jpg). Gambar Wajib Diisi.</p>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg">
                            Simpan Produk
                        </button>
                    </div>

                </form>
                
            </div>
            
        </div>
    </div>
</x-app-layout>