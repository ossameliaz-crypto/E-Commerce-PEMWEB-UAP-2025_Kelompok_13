<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom user_id setelah kolom id
            // PENTING: Saya tambahkan 'nullable()' agar tidak error jika sudah ada data transaksi lama
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
            
            // Menambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['user_id']);
            // Baru hapus kolomnya
            $table->dropColumn('user_id');
        });
    }
};