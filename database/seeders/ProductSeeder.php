<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->count() === 0) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Smartphone flagship dengan kamera 200MP dan performa tinggi. Layar Dynamic AMOLED 2X 6.1" dengan refresh rate 120Hz.',
                'price' => 12000000,
                'stock' => 25,
                'category' => 'Elektronik'
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'iPhone terbaru dengan chip A17 Pro dan kamera telephoto 3x. Material titanium premium dengan USB-C.',
                'price' => 18000000,
                'stock' => 15,
                'category' => 'Elektronik'
            ],
            [
                'name' => 'Kemeja Batik Pria',
                'description' => 'Kemeja batik premium dengan motif tradisional. Bahan katun berkualitas tinggi, nyaman untuk acara formal.',
                'price' => 250000,
                'stock' => 50,
                'category' => 'Fashion Pria'
            ],
            [
                'name' => 'Dress Wanita Elegant',
                'description' => 'Dress cantik untuk acara formal dan kasual. Bahan chiffon berkualitas dengan cutting yang elegan.',
                'price' => 180000,
                'stock' => 30,
                'category' => 'Fashion Wanita'
            ],
            [
                'name' => 'Lipstik Matte Premium',
                'description' => 'Lipstik dengan formula tahan lama dan tidak kering. Tersedia dalam berbagai warna cantik.',
                'price' => 85000,
                'stock' => 100,
                'category' => 'Kesehatan & Kecantikan'
            ],
            [
                'name' => 'Set Peralatan Dapur',
                'description' => 'Set lengkap peralatan dapur anti lengket. Terdiri dari 7 pieces dengan kualitas premium.',
                'price' => 450000,
                'stock' => 20,
                'category' => 'Rumah & Taman'
            ],
            [
                'name' => 'Sepatu Lari Nike',
                'description' => 'Sepatu olahraga dengan teknologi Air Max. Nyaman untuk lari jarak jauh dan aktivitas olahraga.',
                'price' => 1200000,
                'stock' => 35,
                'category' => 'Olahraga & Outdoor'
            ],
            [
                'name' => 'Ban Mobil Bridgestone',
                'description' => 'Ban berkualitas tinggi dengan grip yang baik. Cocok untuk berbagai kondisi jalan.',
                'price' => 800000,
                'stock' => 40,
                'category' => 'Otomotif'
            ],
            [
                'name' => 'Novel Best Seller',
                'description' => 'Novel populer dengan cerita yang menarik. Best seller nasional dengan rating tinggi.',
                'price' => 65000,
                'stock' => 75,
                'category' => 'Buku & Hobi'
            ],
            [
                'name' => 'Kopi Arabica Premium',
                'description' => 'Kopi arabica pilihan dengan cita rasa yang khas. Dipanggang sempurna untuk kenikmatan maksimal.',
                'price' => 120000,
                'stock' => 60,
                'category' => 'Makanan & Minuman'
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();

            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'category_id' => $category->id
                ]);
            }
        }

        $this->command->info('Products seeded successfully!');
    }
}
