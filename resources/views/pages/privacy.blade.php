<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - Build-A-Teddy</title>
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
            <span class="text-4xl">🔒</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">PRIVACY POLICY</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Keamanan Data Anda</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali</a>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-extrabold text-gray-900 mb-4">Kebijakan Privasi Pengguna</h1>
            <p class="text-lg text-gray-500">Kami menjamin keamanan dan kerahasiaan data pribadi Anda 100%.</p>
        </div>

        <div class="space-y-10">
            <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-orange-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4">1. Data yang Kami Kumpulkan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Kami mengumpulkan Nama, Alamat Pengiriman, Alamat Email, dan Nomor Telepon untuk tujuan pemrosesan pesanan. Data pembayaran (kartu kredit/bank) diproses oleh pihak ketiga (Payment Gateway) yang terenkripsi dan tidak disimpan di server kami.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-blue-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4">2. Tujuan Penggunaan Data</h3>
                <p class="text-gray-600 leading-relaxed">
                    Data Anda digunakan untuk: (a) Menyelesaikan transaksi dan mengirim produk; (b) Melakukan komunikasi terkait status pesanan; (c) Meningkatkan layanan dan pengalaman kustomisasi di Workshop.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-green-500/80">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4">3. Keamanan Rekaman Suara</h3>
                <p class="text-gray-600 leading-relaxed">
                    Rekaman suara yang Anda kustomisasi akan disimpan di server terenkripsi dan hanya digunakan satu kali untuk proses produksi boneka Anda. Setelah pesanan selesai, data rekaman akan dihapus dari server dalam waktu 30 hari.
                </p>
            </div>
        </div>

        <div class="mt-12 text-center pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-500 italic">Terakhir Diperbarui: 12 Desember 2025</p>
        </div>
    </div>

</body>
</html>