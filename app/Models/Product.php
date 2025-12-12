<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\TransactionDetail;
use App\Models\ProductReview;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'condition',
        'price',
        'weight',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'weight' => 'integer',
    ];
    
    // --- RELATIONS ---

    // Relasi ke Toko (stores)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class); 
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}