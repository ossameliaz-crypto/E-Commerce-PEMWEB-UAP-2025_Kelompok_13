<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'base_model',
        'size',
        'outfit_id',
        'accessory_id',
        'voice_type',
        'voice_file',
        'scent_type',
        'gift_box',
        'card_message',
        'is_dressed',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}