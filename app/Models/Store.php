<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

use App\Models\User; 
use App\Models\StoreBalance; 
use App\Models\Product; 
use App\Models\Transaction; 

class Store extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'address_id',
        'city',
        'address',
        'postal_code',
        'is_verified',
    ];

    // Relasi 1:1 ke User (Pemilik Toko)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 1:1 ke Saldo Toko
    public function storeBalance() 
    {
        return $this->hasOne(StoreBalance::class);
    }

    // Relasi 1:M ke Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relasi 1:M ke Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
