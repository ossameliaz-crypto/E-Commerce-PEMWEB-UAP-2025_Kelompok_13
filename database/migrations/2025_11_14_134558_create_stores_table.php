<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel stores (Toko Penjual).
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); 
            
            // Memastikan 1 user hanya punya 1 toko.
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users') 
                  ->cascadeOnDelete() // Jika user (seller) dihapus, toko juga terhapus.
                  ->comment('ID pengguna (Seller) yang memiliki toko'); 

            $table->string('name');
            $table->string('logo')->nullable();
            $table->text('about')->nullable();
            $table->string('phone')->nullable();
            
            // Kolom Alamat
            $table->string('address_id')->nullable()->comment('ID Alamat Eksternal/Layanan');
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            
            // Status Verifikasi Toko
            $table->boolean('is_verified')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};