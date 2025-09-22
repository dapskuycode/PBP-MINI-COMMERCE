<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Fashion Pria',
            'Fashion Wanita',
            'Kesehatan & Kecantikan',
            'Rumah & Taman',
            'Olahraga & Outdoor',
            'Otomotif',
            'Buku & Hobi',
            'Makanan & Minuman',
            'Peralatan Kantor'
        ];

        foreach ($categories as $categoryName) {
            Category::updateOrCreate(
                ['name' => $categoryName],
                ['name' => $categoryName]
            );
        }
    }
}
