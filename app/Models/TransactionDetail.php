<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'voice_message',    // URL file rekaman atau kode suara
        'scent',            // vanilla, chocolate
        'gift_box',         // premium, birthday
        'is_dressed',       // true/false
        'price'             // Harga saat beli
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}