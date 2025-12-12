<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. PANGGIL SEEDER LAINNYA DI SINI
        $this->call([
            ProductCategorySeeder::class, 
        ]);
        
        // 2. MEMBUAT ADMIN USER (Pastikan peran/role sudah dibuat oleh RoleSeeder)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), 
        ]);

        // Opsional: Buat Seller User
        User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}