<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Kaos Polos Hitam',
            'price' => 55000,
            'stock' => 120,
            'description' => 'Kaos polos bahan cotton combed.',
            'image' => 'kaos.jpg'
        ]);

        Product::create([
            'name' => 'Hoodie Oversize',
            'price' => 150000,
            'stock' => 45,
            'description' => 'Hoodie model oversize cocok dipakai harian.',
            'image' => 'hoodie.jpg'
        ]);
    }
}
