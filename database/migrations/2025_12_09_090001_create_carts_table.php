<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Detail Custom Boneka
            $table->string('base_model'); // coklat, krem, panda
            $table->string('size');       // S, M, L
            $table->string('outfit_id')->nullable();
            $table->string('accessory_id')->nullable();
            
            // Fitur Suara & Wangi
            $table->string('voice_type')->nullable(); // love, bday, record
            $table->string('voice_file')->nullable(); // Path file rekaman (jika ada)
            $table->string('scent_type')->nullable(); // vanilla, strawberry
            
            // Fitur Hadiah
            $table->string('gift_box')->nullable();   // premium, birthday
            $table->text('card_message')->nullable(); // Pesan kartu ucapan
            $table->boolean('is_dressed')->default(true); // true = dipakaikan, false = pisah
            
            // Harga
            $table->decimal('total_price', 15, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};