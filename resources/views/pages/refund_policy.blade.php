<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Pengembalian Dana - Build-A-Teddy</title>
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
            <span class="text-4xl">💸</span>
            <div><span class="font-display font-extrabold text-orange-600 text-2xl block">REFUND POLICY</span><span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Money Back Guarantee</span></div>
        </a>
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-orange-600 font-bold">Kembali</a>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-extrabold text-gray-900 mb-4">Kebijakan Penukaran & Pengembalian Dana</h1>
            <p class="text-lg text-gray-500">Kepuasan Anda adalah prioritas kami. Baca syarat dan ketentuan di bawah ini.</p>
        </div>

        <div class="space-y-10">
            <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-orange-500/80 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4 flex items-center gap-3"><span class="text-3xl text-orange-600">1.</span> Masa Berlaku</h3>
                <p class="text-gray-600 leading-relaxed mb-3">
                    Anda memiliki waktu 7 hari kalender sejak barang diterima untuk mengajukan penukaran atau pengembalian dana.
                </p>
                <div class="text-sm bg-orange-50 p-4 rounded-xl font-medium text-orange-700">
                    <span class="font-bold">Penting:</span> Pengembalian dana hanya berlaku jika produk yang diterima cacat produksi atau terjadi kesalahan pengiriman dari pihak kami.
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-blue-500/80 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4 flex items-center gap-3"><span class="text-3xl text-blue-600">2.</span> Syarat Kondisi Produk</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-600 leading-relaxed pl-4">
                    <li>Produk harus dalam kondisi baru (belum pernah dicuci atau digunakan).</li>
                    <li>Label harga dan tag Build-A-Teddy harus **masih terpasang**.</li>
                    <li>Untuk boneka yang dikustomisasi suara, pengembalian dana tidak berlaku jika kesalahan berasal dari rekaman suara pelanggan.</li>
                </ul>
            </div>
            
            <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-green-500/80 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-display font-bold text-gray-800 mb-4 flex items-center gap-3"><span class="text-3xl text-green-600">3.</span> Prosedur Pengajuan</h3>
                <ol class="list-decimal list-inside space-y-2 text-gray-600 leading-relaxed pl-4">
                    <li>Hubungi Customer Service kami melalui `{{ route('contact') }}`.</li>
                    <li>Sertakan Nomor Order dan Bukti Video/Foto produk yang bermasalah.</li>
                    <li>Tim kami akan memproses dan memberikan alamat pengembalian dalam waktu 24 jam.</li>
                </ol>
            </div>
        </div>

        <div class="mt-12 text-center pt-8 border-t border-gray-200">
            <a href="{{ route('contact') }}" class="inline-block bg-orange-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg hover:bg-orange-700 hover:-translate-y-1 transition transform">
                Ajukan Pengembalian Sekarang
            </a>
        </div>
    </div>

</body>
</html>