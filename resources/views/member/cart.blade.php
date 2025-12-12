<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-800 leading-tight">
            {{ __('🧥 Lemari Saya (Keranjang Belanja)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Jika Keranjang Kosong --}}
            @if ($cartItems->isEmpty())
                <div class="text-center bg-white p-10 rounded-3xl shadow-lg">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-bold text-gray-800">Ups! Lemari Kamu Kosong.</h3>
                    <p class="text-gray-500 mt-2">Belum ada item dari Workshop atau Katalog di keranjangmu.</p>
                    
                    <div class="mt-6 flex justify-center space-x-4">
                        <a href="{{ route('workshop') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-full text-sm font-bold hover:bg-orange-700 transition shadow-lg">
                            🎨 Mulai Workshop
                        </a>
                        {{-- Asumsi link Katalog adalah /collection --}}
                        <a href="/collection" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-full text-sm font-bold hover:bg-gray-300 transition">
                            🎁 Jelajahi Katalog
                        </a>
                    </div>
                </div>
            @else
                {{-- Tampilan Keranjang Jika Ada Item --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Kolom Kiri: Daftar Item Keranjang --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="bg-white p-4 rounded-2xl shadow-md flex items-center border border-gray-100">
                                
                                {{-- Kotak centang (untuk Bulk Delete) --}}
                                <input type="checkbox" name="cart_item_ids[]" value="{{ $item->id }}" class="form-checkbox h-5 w-5 text-orange-600 rounded mr-4">
                                
                                {{-- Gambar (Jika ada) --}}
                                <div class="w-20 h-20 bg-gray-100 rounded-lg mr-4 flex-shrink-0">
                                    {{-- Ganti dengan gambar item --}}
                                    <img src="{{ $item->image_url ?? 'default-image.jpg' }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-lg">
                                </div>

                                {{-- Detail Item --}}
                                <div class="flex-grow">
                                    <p class="font-bold text-lg text-gray-900">{{ $item->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->description }}</p>
                                    <p class="text-base font-extrabold text-orange-600 mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                
                                {{-- Pengaturan Kuantitas & Hapus --}}
                                <div class="flex items-center space-x-4 flex-shrink-0 ml-4">
                                    
                                    {{-- Form Update Kuantitas (Perlu AJAX atau Form Submit) --}}
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" class="p-2 text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                        <input type="number" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-none focus:ring-0 p-1 text-sm">
                                        <button type="button" class="p-2 text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                                    </div>

                                    {{-- Tombol Hapus (Perlu Form DELETE) --}}
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 11.14A2 2 0 0116.14 20H7.86a2 2 0 01-1.99-1.86L5 7m4 0h6m-3 0V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        
                        {{-- Tombol Bulk Delete (di bawah daftar item) --}}
                        <div class="text-right mt-4">
                            <button type="button" id="bulkDeleteButton" class="text-sm text-red-500 hover:text-red-700 font-bold flex items-center ml-auto">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 11.14A2 2 0 0116.14 20H7.86a2 2 0 01-1.99-1.86L5 7m4 0h6m-3 0V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3"></path></svg>
                                Hapus Item Terpilih
                            </button>
                        </div>
                    </div>
                    
                    {{-- Kolom Kanan: Ringkasan Belanja --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-4">
                            <h4 class="font-extrabold text-xl text-gray-800 mb-4">{{ __('Ringkasan Belanja') }}</h4>
                            
                            {{-- Subtotal --}}
                            <div class="flex justify-between text-gray-600 mb-2">
                                <span>Subtotal ({{ $cartItems->count() }} Item)</span>
                                <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>

                            {{-- Diskon (Jika ada) --}}
                            <div class="flex justify-between text-green-600 mb-4">
                                <span>Diskon</span>
                                <span>- Rp 0</span>
                            </div>

                            <hr class="my-4 border-gray-200">
                            
                            {{-- Total --}}
                            <div class="flex justify-between text-xl font-extrabold text-gray-900 mb-6">
                                <span>Total Pembayaran</span>
                                <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>

                            {{-- Tombol Checkout --}}
                            <a href="{{ route('checkout') }}" class="w-full block text-center px-6 py-3 bg-orange-600 text-white rounded-full text-base font-bold hover:bg-orange-700 transition shadow-lg">
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Script untuk Bulk Delete (memerlukan JQuery atau JS Native) --}}
    {{-- Anda harus membuat fungsi JS yang mengumpulkan ID item yang dicentang dan mengirimnya ke route('cart.bulk_destroy') --}}
</x-app-layout>