<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Build-A-Teddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-orange-50/50 min-h-screen">

    <div class="max-w-4xl mx-auto p-6 md:p-10">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8">Pengiriman 📦</h1>

        <form action="{{ route('payment') }}" method="GET" class="flex flex-col md:flex-row gap-8">
            <div class="md:w-2/3 space-y-6">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-orange-100">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">📍 Alamat Penerima</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Penerima" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none">
                        <input type="text" placeholder="Nomor HP" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none">
                        <textarea placeholder="Alamat Lengkap (Jalan, No. Rumah, RT/RW)" rows="3" class="md:col-span-2 w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none"></textarea>
                        <input type="text" placeholder="Kota / Kecamatan" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none">
                        <input type="text" placeholder="Kode Pos" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-200 outline-none">
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-orange-100">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">🚚 Pilih Pengiriman</h3>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="courier" class="text-orange-600 focus:ring-orange-500">
                                <div>
                                    <span class="font-bold block">JNE Reguler</span>
                                    <span class="text-xs text-gray-500">Estimasi 2-3 Hari</span>
                                </div>
                            </div>
                            <span class="font-bold text-gray-800">Rp 20.000</span>
                        </label>
                        <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-orange-500 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="courier" class="text-orange-600 focus:ring-orange-500">
                                <div>
                                    <span class="font-bold block">J&T Express</span>
                                    <span class="text-xs text-gray-500">Estimasi 1-2 Hari</span>
                                </div>
                            </div>
                            <span class="font-bold text-gray-800">Rp 25.000</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="md:w-1/3">
                <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-orange-100 sticky top-10">
                    <h3 class="font-bold text-lg mb-6">Ringkasan</h3>
                    
                    <!-- Item List -->
                    <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-2xl">🧸</div>
                            <div>
                                <p class="font-bold text-sm">Custom Teddy</p>
                                <p class="text-xs text-gray-500">Varian: Coklat</p>
                                <p class="text-orange-600 font-bold text-sm">Rp 150.000</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between"><span>Subtotal</span><span>Rp 150.000</span></div>
                        <div class="flex justify-between"><span>Ongkir</span><span>Rp 20.000</span></div>
                        <div class="flex justify-between font-bold text-lg text-gray-900 pt-4 border-t border-dashed">
                            <span>Total</span><span>Rp 170.000</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-4 rounded-xl hover:bg-orange-700 shadow-lg transform hover:-translate-y-1 transition">
                        Lanjut Bayar ➜
                    </button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>