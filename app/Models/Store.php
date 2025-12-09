<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import Model lain untuk relasi
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class Store extends Model
{
    use HasFactory;

    /**
     * Daftar kolom yang boleh diisi (Mass Assignable).
     * Harus SAMA PERSIS dengan nama kolom di Database Migration.
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',         // Wajib ada buat URL cantik (toko-budi)
        'description',  // Kita pakai 'description', bukan 'about'
        'logo',
        'phone',
        'address',      // Langsung teks alamat, tidak pakai ID
        'city',
        'postal_code',
        'balance',      // Saldo toko
        'is_verified',
    ];

    // --- RELASI (RELATIONSHIPS) ---

    // 1. Toko milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Toko punya banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 3. Toko punya banyak Transaksi (Pesanan Masuk)
    // Relasi ini diambil lewat produk yang ada di detail transaksi
    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Product::class);
    }
}