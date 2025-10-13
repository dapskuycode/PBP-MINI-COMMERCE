<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create categories for oleh-oleh (souvenir) shop
        $makanan = Category::create(['name' => 'Makanan']);
        $minumanManis = Category::create(['name' => 'Minuman Manis']);
        $kemasan = Category::create(['name' => 'Kemasan']);
        $makananKhas = Category::create(['name' => 'Makanan Khas Daerah']);
        $aksesoris = Category::create(['name' => 'Aksesoris & Souvenir']);

        // Create products for each category
        $products = [
            // Makanan
            [
                'name' => 'Keripik Singkong Original',
                'description' => 'Keripik singkong renyah dengan rasa original yang gurih. Cocok untuk camilan atau oleh-oleh.',
                'price' => 15000,
                'stock' => 50,
                'discount' => 0,
                'category_id' => $makanan->id
            ],
            [
                'name' => 'Kacang Mete Madu',
                'description' => 'Kacang mete premium dengan balutan madu asli. Kemasan 250 gram.',
                'price' => 45000,
                'stock' => 30,
                'discount' => 10,
                'category_id' => $makanan->id
            ],
            [
                'name' => 'Rempeyek Kacang Tanah',
                'description' => 'Rempeyek tradisional dengan kacang tanah pilihan. Renyah dan gurih.',
                'price' => 12000,
                'stock' => 40,
                'discount' => 0,
                'category_id' => $makanan->id
            ],
            [
                'name' => 'Kerupuk Udang Sidoarjo',
                'description' => 'Kerupuk udang asli Sidoarjo dengan citarasa udang yang kuat.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 5,
                'category_id' => $makanan->id
            ],

            // Minuman Manis
            [
                'name' => 'Sirup Pandan',
                'description' => 'Sirup pandan asli dengan aroma dan rasa pandan yang segar. Botol 500ml.',
                'price' => 18000,
                'stock' => 25,
                'discount' => 0,
                'category_id' => $minumanManis->id
            ],
            [
                'name' => 'Madu Murni Hutan',
                'description' => 'Madu murni dari hutan dengan kualitas premium. Botol kaca 300ml.',
                'price' => 75000,
                'stock' => 20,
                'discount' => 15,
                'category_id' => $minumanManis->id
            ],
            [
                'name' => 'Sirup Markisa',
                'description' => 'Sirup markisa segar dengan rasa asam manis yang menyegarkan.',
                'price' => 22000,
                'stock' => 30,
                'discount' => 0,
                'category_id' => $minumanManis->id
            ],
            [
                'name' => 'Wedang Jahe Instant',
                'description' => 'Minuman jahe instant hangat dengan campuran gula aren. Kemasan sachet isi 10.',
                'price' => 28000,
                'stock' => 45,
                'discount' => 8,
                'category_id' => $minumanManis->id
            ],

            // Kemasan
            [
                'name' => 'Tas Rajut Pandan',
                'description' => 'Tas rajut dari pandan dengan motif tradisional. Ukuran sedang.',
                'price' => 35000,
                'stock' => 15,
                'discount' => 0,
                'category_id' => $kemasan->id
            ],
            [
                'name' => 'Kotak Kayu Jati',
                'description' => 'Kotak penyimpanan dari kayu jati dengan ukiran tradisional.',
                'price' => 85000,
                'stock' => 12,
                'discount' => 20,
                'category_id' => $kemasan->id
            ],
            [
                'name' => 'Besek Bambu Mini',
                'description' => 'Besek bambu ukuran mini untuk kemasan oleh-oleh. Set isi 5 buah.',
                'price' => 15000,
                'stock' => 25,
                'discount' => 0,
                'category_id' => $kemasan->id
            ],
            [
                'name' => 'Tas Anyaman Rotan',
                'description' => 'Tas anyaman rotan dengan desain modern. Cocok untuk souvenir.',
                'price' => 55000,
                'stock' => 18,
                'discount' => 12,
                'category_id' => $kemasan->id
            ],

            // Makanan Khas Daerah
            [
                'name' => 'Dodol Betawi',
                'description' => 'Dodol khas Betawi dengan rasa manis legit. Kemasan 250 gram.',
                'price' => 30000,
                'stock' => 40,
                'discount' => 0,
                'category_id' => $makananKhas->id
            ],
            [
                'name' => 'Kerak Telor Kering',
                'description' => 'Kerak telor khas Jakarta dalam bentuk kering untuk oleh-oleh.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 5,
                'category_id' => $makananKhas->id
            ],
            [
                'name' => 'Serundeng Kelapa Surabaya',
                'description' => 'Serundeng kelapa khas Surabaya dengan bumbu rempah tradisional.',
                'price' => 20000,
                'stock' => 30,
                'discount' => 0,
                'category_id' => $makananKhas->id
            ],
            [
                'name' => 'Abon Sapi Malang',
                'description' => 'Abon sapi khas Malang dengan cita rasa gurih dan manis.',
                'price' => 45000,
                'stock' => 25,
                'discount' => 15,
                'category_id' => $makananKhas->id
            ],
            [
                'name' => 'Kue Lumpur Sidoarjo',
                'description' => 'Kue lumpur khas Sidoarjo dengan topping kismis. Kemasan box isi 6.',
                'price' => 35000,
                'stock' => 20,
                'discount' => 10,
                'category_id' => $makananKhas->id
            ],

            // Aksesoris & Souvenir
            [
                'name' => 'Gantungan Kunci Wayang',
                'description' => 'Gantungan kunci miniatur wayang kulit dengan berbagai karakter.',
                'price' => 8000,
                'stock' => 60,
                'discount' => 0,
                'category_id' => $aksesoris->id
            ],
            [
                'name' => 'Magnet Kulkas Batik',
                'description' => 'Magnet kulkas dengan motif batik khas Indonesia. Set isi 3.',
                'price' => 12000,
                'stock' => 50,
                'discount' => 0,
                'category_id' => $aksesoris->id
            ],
            [
                'name' => 'Miniatur Becak Jakarta',
                'description' => 'Miniatur becak khas Jakarta dari logam dengan detail yang indah.',
                'price' => 65000,
                'stock' => 15,
                'discount' => 18,
                'category_id' => $aksesoris->id
            ],
            [
                'name' => 'Kipas Batik Tradisional',
                'description' => 'Kipas lipat dengan motif batik tradisional. Cocok untuk souvenir.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 8,
                'category_id' => $aksesoris->id
            ],
            [
                'name' => 'Kaos Jakarta Heritage',
                'description' => 'Kaos dengan desain heritage Jakarta. Tersedia ukuran S, M, L, XL.',
                'price' => 85000,
                'stock' => 40,
                'discount' => 25,
                'category_id' => $aksesoris->id
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
