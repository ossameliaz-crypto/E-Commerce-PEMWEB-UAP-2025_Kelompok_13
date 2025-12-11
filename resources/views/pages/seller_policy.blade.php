<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Seller - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #FFFBF5; }
        h1, h2, h3, .font-display { font-family: 'Fredoka', sans-serif; }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { orange: { 50: '#fff7ed', 600: '#ea580c' } } } } }
    </script>
</head>
<body class="text-gray-800">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-orange-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <span class="text-4xl">⚖️</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">SELLER POLICY</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Legal & Agreement</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali</a>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-extrabold text-gray-900 mb-4">Syarat & Ketentuan Penjual</h1>
            <p class="text-lg text-gray-500">Aturan resmi bagi semua kreator yang terdaftar di Build-A-Teddy Marketplace.</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-orange-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-2">1. Standar Kualitas Produk</h3>
                <p class="text-gray-600 leading-relaxed">
                    Produk harus buatan tangan atau produksi skala kecil dengan jahitan rapi. Bahan harus lolos uji keamanan anak (non-toxic). Kami berhak menolak produk yang dinilai tidak memenuhi standar kualitas premium.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-blue-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-2">2. Komisi & Pembayaran</h3>
                <p class="text-gray-600 leading-relaxed">
                    Platform mengambil komisi sebesar 15% dari harga jual produk. Sisa 85% akan dicairkan setiap hari Jumat pukul 14:00 WIB ke rekening bank Seller yang terdaftar.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-green-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-2">3. Ketentuan Pengiriman</h3>
                <p class="text-gray-600 leading-relaxed">
                    Seller wajib memproses dan mengirimkan pesanan maksimal 1x24 jam (Hari Kerja). Keterlambatan berulang dapat mengakibatkan penangguhan akun.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-red-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-2">4. Hak Cipta Desain</h3>
                <p class="text-gray-600 leading-relaxed">
                    Seller bertanggung jawab penuh atas orisinalitas desain. Dilarang keras menjiplak desain brand besar atau kreator lain. Build-A-Teddy berhak menurunkan produk yang melanggar hak cipta.
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('store.register') }}" class="inline-block bg-orange-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg hover:bg-orange-700 hover:-translate-y-1 transition transform">
                Daftar Sekarang & Mulai Jual
            </a>
        </div>
    </div>

</body>
</html>