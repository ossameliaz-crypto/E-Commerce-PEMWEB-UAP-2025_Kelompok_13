<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Boneka Dasar',      // BASE
            'Pakaian Boneka',    // OUTFIT
            'Aksesoris Boneka',  // ACC
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'tagline' => 'Kategori untuk ' . $category, 
                'description' => 'Deskripsi default untuk kategori ' . $category, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}