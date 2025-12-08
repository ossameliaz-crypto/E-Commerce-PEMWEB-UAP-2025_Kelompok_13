<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tiga tabel standar: users, password_reset_tokens, dan sessions.
     */
    public function up(): void
    {
        // 1. Tabel users (Untuk Login/Register, Role, dan Profil E-Commerce)
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key, Auto-increment
            
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); 
            
            // KOLOM E-COMMERCE & MULTI-ROLE
            $table->enum('role', ['admin', 'member','seller'])->default('member')->comment('Role pengguna untuk akses halaman tertentu');
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            
            // VERIFIKASI & KEAMANAN
            $table->timestamp('email_verified_at')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel password_reset_tokens (Untuk fitur 'Forgot Password')
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Tabel sessions (Untuk fitur 'Remember Me' dan manajemen sesi)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            
            // PERBAIKAN: Menggunakan ->constrained() untuk Foreign Key ke tabel users
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     * Perintah untuk menghapus tabel saat rollback/refresh.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};