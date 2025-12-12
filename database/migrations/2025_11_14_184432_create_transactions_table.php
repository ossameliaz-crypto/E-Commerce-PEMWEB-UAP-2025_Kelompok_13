<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. TABEL TRANSACTIONS (Nota Tagihan)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_code')->unique(); // Contoh: TRX-998811
            
            // Info Pengiriman
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('address'); // Alamat lengkap gabungan
            $table->string('courier');
            $table->decimal('shipping_cost', 12, 2);
            
            $table->decimal('total_price', 12, 2); // Total Akhir (Barang + Ongkir)
            $table->string('status')->default('pending_payment'); 
            $table->timestamps();
        });

        // 2. TABEL TRANSACTION DETAILS (Detail Boneka Custom)
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            
            // --- INI KOLOM YANG KITA TAMBAH BIAR LENGKAP ---
            $table->string('base_model');       // choco, panda, dll
            $table->string('size');             // S, M, XL
            $table->string('outfit_id')->nullable();     // Baju apa
            $table->string('accessory_id')->nullable();  // Aksesoris apa
            
            // Suara & Rekaman
            $table->string('voice_type')->nullable();    // Jenis suara (love, bday, record)
            $table->string('voice_file')->nullable();    // Path file rekaman suara (PENTING)
            
            $table->string('scent_type')->nullable();    // Wangi
            $table->string('gift_box')->nullable();      // Bungkus kado
            $table->text('card_message')->nullable();    // Pesan kartu
            $table->boolean('is_dressed')->default(false);
            
            $table->decimal('price', 12, 2); // Harga per item saat beli
            $table->timestamps();
        });

        // 3. TABEL PAYMENTS (Simpan Bukti Bayar)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('payment_method');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
    }
};