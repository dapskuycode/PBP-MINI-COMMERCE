<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create categories first
        $electronics = Category::create(['name' => 'Elektronik']);
        $fashion = Category::create(['name' => 'Fashion']);
        $sports = Category::create(['name' => 'Olahraga']);
        $books = Category::create(['name' => 'Buku']);

        // Create sample products
        $products = [
            [
                'name' => 'Laptop',
                'description' => 'Laptop gaming terbaru dengan spesifikasi tinggi.',
                'price' => 15000000,
                'stock' => 10,
                'category_id' => $electronics->id
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
