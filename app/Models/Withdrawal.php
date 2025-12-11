<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'amount',
        'bank_name',
        'account_number',
        'status', // pending, approved, rejected
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}