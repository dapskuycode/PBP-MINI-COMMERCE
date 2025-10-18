<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan'],
            ['name' => 'Minuman Manis'],
            ['name' => 'Kemasan'],
            ['name' => 'Makanan Khas Daerah'],
            ['name' => 'Aksesoris & Souvenir'],
            ['name' => 'Kerajinan Tangan'],
            ['name' => 'Batik & Tekstil'],
            ['name' => 'Bumbu & Rempah'],
            ['name' => 'Kue & Dessert'],
            ['name' => 'Produk Organik']
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']]);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}