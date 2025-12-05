<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Produk - Seller Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex">
        <!-- Sidebar (Simpel) -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-6 text-2xl font-bold text-orange-600">🧸 Seller Panel</div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-orange-50 rounded-lg">Dashboard</a>
                <a href="#" class="block px-4 py-2 bg-orange-100 text-orange-700 font-bold rounded-lg">Upload Produk</a>
                <a href="{{ url('/') }}" class="block px-4 py-2 text-gray-400 hover:text-orange-600 mt-10">Kembali ke Web</a>
            </nav>
        </aside>

        <!-- Form Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Upload Karya Baru</h1>
            <p class="text-gray-500 mb-8">Pastikan gambarmu sesuai panduan agar pas di badan boneka.</p>

            <form action="#" method="POST" enctype="multipart/form-data" class="max-w-4xl bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Kiri: Info Produk -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="name" placeholder="Contoh: Hoodie Biru Polos" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                                <input type="number" name="price" placeholder="50000" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                                <input type="number" name="stock" placeholder="100" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori (Layering)</label>
                            <select name="category" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none bg-white">
                                <option value="outfit">👕 Outfit (Baju/Celana)</option>
                                <option value="accessory">👓 Accessories (Kacamata/Topi)</option>
                            </select>
                            <p class="text-xs text-orange-500 mt-1">*Pilih sesuai jenis agar posisi layering benar.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none"></textarea>
                        </div>
                    </div>

                    <!-- Kanan: Upload & Preview -->
                    <div class="bg-orange-50 p-6 rounded-2xl border-2 border-dashed border-orange-200 text-center" x-data="{ imagePreview: null }">
                        <label class="block text-sm font-bold text-gray-700 mb-4">File Gambar (PNG Transparan)</label>
                        
                        <!-- Area Preview -->
                        <div class="relative w-64 h-64 mx-auto bg-white rounded-xl shadow-inner flex items-center justify-center overflow-hidden mb-4 border border-gray-200">
                            <!-- Panduan Base Body (Transparan) buat ngepasin posisi -->
                            <img src="https://via.placeholder.com/200x250?text=Base+Bear+Template" class="absolute opacity-30 w-48 pointer-events-none">
                            
                            <template x-if="!imagePreview">
                                <div class="text-gray-400 text-sm">Preview akan muncul di sini</div>
                            </template>
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="absolute w-48 z-10">
                            </template>
                        </div>

                        <label class="cursor-pointer bg-orange-600 text-white px-6 py-2 rounded-full font-bold hover:bg-orange-700 transition inline-block">
                            <span>Upload File</span>
                            <input type="file" name="image" class="hidden" accept="image/png" 
                                   @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                        </label>
                        <p class="text-xs text-gray-500 mt-2">Wajib PNG. Max 2MB.</p>
                    </div>

                </div>

                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg transform hover:-translate-y-1 transition">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
