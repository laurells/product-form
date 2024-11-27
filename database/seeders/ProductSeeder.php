<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Product 1',
            'quantity' => 100,
            'price' => 10.00,
            'datetime' => now(),
        ]);

        Product::create([
            'name' => 'Product 2',
            'quantity' => 50,
            'price' => 15.00,
            'datetime' => now(),
        ]);
    }
}
