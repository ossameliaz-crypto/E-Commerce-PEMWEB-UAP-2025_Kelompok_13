<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class Store extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'name',
        'slug',         
        'description',  
        'logo',
        'phone',
        'address',      
        'city',
        'postal_code',
        'balance',     
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
    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Product::class);
    }
}