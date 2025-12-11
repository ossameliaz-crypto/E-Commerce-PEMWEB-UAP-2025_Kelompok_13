<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_code',     // TRX-XXXX
        'status',           // pending, paid, shipped, done
        'total_price',
        'recipient_name',
        'recipient_phone',
        'address',
        'courier',
        'resi_number'
    ];

    // Relasi ke Pembeli
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Barang (Isinya banyak item)
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}