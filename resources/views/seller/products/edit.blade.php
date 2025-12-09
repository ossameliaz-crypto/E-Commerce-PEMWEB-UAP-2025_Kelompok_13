<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4 text-sm font-medium text-gray-600">
                <a href="{{ route('seller.dashboard') }}" class="text-orange-500 hover:text-orange-600">Seller Panel</a> /
                <span>Edit Produk</span>
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                
                <h3 class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-4">
                    Perbarui Detail Produk
                </h3>

                <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" id="name" name="name" 
                               {{-- Mengisi nilai lama atau nilai saat ini dari database --}}
                               value="{{ old('name', $product->name) }}"
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
                                {{-- Menandai kategori yang sedang digunakan produk --}}
                                @php $selected = old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' @endphp
                                <option value="{{ $category->id }}" {{ $selected }}>
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
                                  placeholder="Jelaskan produk Anda secara detail..." required>{{ old('description', $product->description) }}</textarea>
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
                                {{-- Menandai kondisi yang sedang digunakan produk --}}
                                <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru (New)</option>
                                <option value="second" {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Bekas (Second)</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat (gram)</label>
                            <input type="number" id="weight" name="weight" 
                                    value="{{ old('weight', $product->weight) }}"
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
                                    value="{{ old('price', $product->price) }}"
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
                                    value="{{ old('stock', $product->stock) }}"
                                    min="0"
                                    class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('stock') border-red-500 @enderror" 
                                    placeholder="Contoh: 120" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-8 p-4 border border-gray-200 rounded-xl bg-gray-50">
                        <p class="text-sm font-medium text-gray-700 mb-3">Gambar Saat Ini:</p>
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="Gambar Produk" class="h-32 w-32 object-cover rounded-lg mb-4 border border-gray-300">
                        @else
                            <p class="text-xs text-gray-500 mb-3">Belum ada gambar yang diupload.</p>
                        @endif
                        
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Baru (Opsional)</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border-gray-300 rounded-xl shadow-sm @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    

                    <div class="flex justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                            Perbarui Produk
                        </button>
                    </div>

                </form>
                
            </div>
            
        </div>
    </div>
</x-app-layout>