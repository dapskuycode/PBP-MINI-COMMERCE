<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ItemPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get existing categories from CategorySeeder
        $makanan = Category::where('name', 'Makanan')->first();
        $minumanManis = Category::where('name', 'Minuman Manis')->first();
        $kemasan = Category::where('name', 'Kemasan')->first();
        $makananKhas = Category::where('name', 'Makanan Khas Daerah')->first();
        $aksesoris = Category::where('name', 'Aksesoris & Souvenir')->first();

        // Ensure categories exist
        if (!$makanan || !$minumanManis || !$kemasan || !$makananKhas || !$aksesoris) {
            $this->command->error('❌ Categories not found! Please run CategorySeeder first.');
            return;
        }

        // Create products for each category with photos
        $products = [
            // Makanan
            [
                'name' => 'Keripik Singkong Original',
                'description' => 'Keripik singkong renyah dengan rasa original yang gurih. Cocok untuk camilan atau oleh-oleh.',
                'price' => 15000,
                'stock' => 50,
                'discount' => 0,
                'category_id' => $makanan->id,
                'photos' => ['https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800']
            ],
            [
                'name' => 'Kacang Mete Madu',
                'description' => 'Kacang mete premium dengan balutan madu asli. Kemasan 250 gram.',
                'price' => 45000,
                'stock' => 30,
                'discount' => 10,
                'category_id' => $makanan->id,
                'photos' => ['https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=800']
            ],
            [
                'name' => 'Rempeyek Kacang Tanah',
                'description' => 'Rempeyek tradisional dengan kacang tanah pilihan. Renyah dan gurih.',
                'price' => 12000,
                'stock' => 40,
                'discount' => 0,
                'category_id' => $makanan->id,
                'photos' => ['https://images.unsplash.com/photo-1544378730-6f3a9b7f6d78?w=800']
            ],
            [
                'name' => 'Kerupuk Udang Sidoarjo',
                'description' => 'Kerupuk udang asli Sidoarjo dengan citarasa udang yang kuat.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 5,
                'category_id' => $makanan->id,
                'photos' => ['https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=800']
            ],

            // Minuman Manis
            [
                'name' => 'Sirup Pandan',
                'description' => 'Sirup pandan asli dengan aroma dan rasa pandan yang segar. Botol 500ml.',
                'price' => 18000,
                'stock' => 25,
                'discount' => 0,
                'category_id' => $minumanManis->id,
                'photos' => ['https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=800']
            ],
            [
                'name' => 'Madu Murni Hutan',
                'description' => 'Madu murni dari hutan dengan kualitas premium. Botol kaca 300ml.',
                'price' => 75000,
                'stock' => 20,
                'discount' => 15,
                'category_id' => $minumanManis->id,
                'photos' => ['https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800']
            ],
            [
                'name' => 'Sirup Markisa',
                'description' => 'Sirup markisa segar dengan rasa asam manis yang menyegarkan.',
                'price' => 22000,
                'stock' => 30,
                'discount' => 0,
                'category_id' => $minumanManis->id,
                'photos' => ['https://images.unsplash.com/photo-1546173159-315724a31696?w=800']
            ],
            [
                'name' => 'Wedang Jahe Instant',
                'description' => 'Minuman jahe instant hangat dengan campuran gula aren. Kemasan sachet isi 10.',
                'price' => 28000,
                'stock' => 45,
                'discount' => 8,
                'category_id' => $minumanManis->id,
                'photos' => ['https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800']
            ],

            // Kemasan
            [
                'name' => 'Tas Rajut Pandan',
                'description' => 'Tas rajut dari pandan dengan motif tradisional. Ukuran sedang.',
                'price' => 35000,
                'stock' => 15,
                'discount' => 0,
                'category_id' => $kemasan->id,
                'photos' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800']
            ],
            [
                'name' => 'Kotak Kayu Jati',
                'description' => 'Kotak penyimpanan dari kayu jati dengan ukiran tradisional.',
                'price' => 85000,
                'stock' => 12,
                'discount' => 20,
                'category_id' => $kemasan->id,
                'photos' => ['https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800']
            ],
            [
                'name' => 'Besek Bambu Mini',
                'description' => 'Besek bambu ukuran mini untuk kemasan oleh-oleh. Set isi 5 buah.',
                'price' => 15000,
                'stock' => 25,
                'discount' => 0,
                'category_id' => $kemasan->id,
                'photos' => ['https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800']
            ],
            [
                'name' => 'Tas Anyaman Rotan',
                'description' => 'Tas anyaman rotan dengan desain modern. Cocok untuk souvenir.',
                'price' => 55000,
                'stock' => 18,
                'discount' => 12,
                'category_id' => $kemasan->id,
                'photos' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800']
            ],

            // Makanan Khas Daerah
            [
                'name' => 'Dodol Betawi',
                'description' => 'Dodol khas Betawi dengan rasa manis legit. Kemasan 250 gram.',
                'price' => 30000,
                'stock' => 40,
                'discount' => 0,
                'category_id' => $makananKhas->id,
                'photos' => ['https://images.unsplash.com/photo-1578849278619-e73505e9610f?w=800']
            ],
            [
                'name' => 'Kerak Telor Kering',
                'description' => 'Kerak telor khas Jakarta dalam bentuk kering untuk oleh-oleh.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 5,
                'category_id' => $makananKhas->id,
                'photos' => ['https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800']
            ],
            [
                'name' => 'Serundeng Kelapa Surabaya',
                'description' => 'Serundeng kelapa khas Surabaya dengan bumbu rempah tradisional.',
                'price' => 20000,
                'stock' => 30,
                'discount' => 0,
                'category_id' => $makananKhas->id,
                'photos' => ['https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800']
            ],
            [
                'name' => 'Abon Sapi Malang',
                'description' => 'Abon sapi khas Malang dengan cita rasa gurih dan manis.',
                'price' => 45000,
                'stock' => 25,
                'discount' => 15,
                'category_id' => $makananKhas->id,
                'photos' => ['https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=800']
            ],
            [
                'name' => 'Kue Lumpur Sidoarjo',
                'description' => 'Kue lumpur khas Sidoarjo dengan topping kismis. Kemasan box isi 6.',
                'price' => 35000,
                'stock' => 20,
                'discount' => 10,
                'category_id' => $makananKhas->id,
                'photos' => ['https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800']
            ],

            // Aksesoris & Souvenir
            [
                'name' => 'Gantungan Kunci Wayang',
                'description' => 'Gantungan kunci miniatur wayang kulit dengan berbagai karakter.',
                'price' => 8000,
                'stock' => 60,
                'discount' => 0,
                'category_id' => $aksesoris->id,
                'photos' => ['https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800']
            ],
            [
                'name' => 'Magnet Kulkas Batik',
                'description' => 'Magnet kulkas dengan motif batik khas Indonesia. Set isi 3.',
                'price' => 12000,
                'stock' => 50,
                'discount' => 0,
                'category_id' => $aksesoris->id,
                'photos' => ['https://images.unsplash.com/photo-1596026045320-4d1b6543df5d?w=800']
            ],
            [
                'name' => 'Miniatur Becak Jakarta',
                'description' => 'Miniatur becak khas Jakarta dari logam dengan detail yang indah.',
                'price' => 65000,
                'stock' => 15,
                'discount' => 18,
                'category_id' => $aksesoris->id,
                'photos' => ['https://images.unsplash.com/photo-1544378730-6f3a9b7f6d78?w=800']
            ],
            [
                'name' => 'Kipas Batik Tradisional',
                'description' => 'Kipas lipat dengan motif batik tradisional. Cocok untuk souvenir.',
                'price' => 25000,
                'stock' => 35,
                'discount' => 8,
                'category_id' => $aksesoris->id,
                'photos' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800']
            ],
            [
                'name' => 'Kaos Jakarta Heritage',
                'description' => 'Kaos dengan desain heritage Jakarta. Tersedia ukuran S, M, L, XL.',
                'price' => 85000,
                'stock' => 40,
                'discount' => 25,
                'category_id' => $aksesoris->id,
                'photos' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800']
            ],
        ];

        foreach ($products as $productData) {
            // Extract photos from product data
            $photos = $productData['photos'] ?? [];
            unset($productData['photos']);
            
            // Create the product
            $product = Product::create($productData);
            
            // Download and save photos
            foreach ($photos as $index => $photoUrl) {
                $this->downloadAndSavePhoto($product, $photoUrl, $index);
            }
        }
    }
    
    /**
     * Download photo from URL and save to storage
     */
    private function downloadAndSavePhoto(Product $product, string $url, int $index = 0)
    {
        try {
            // Download image from URL
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                // Generate filename
                $extension = 'jpg'; // Default to jpg
                $filename = "product_{$product->id}_photo_{$index}.{$extension}";
                $path = "products/{$filename}";
                
                // Save to storage
                Storage::disk('public')->put($path, $response->body());
                
                // Create ItemPhoto record
                ItemPhoto::create([
                    'product_id' => $product->id,
                    'url' => $path,
                    'alt_text' => $product->name . ' - Photo ' . ($index + 1),
                    'is_primary' => $index === 0, // First photo is primary
                ]);
                
                $this->command->info("✅ Downloaded photo for: {$product->name}");
            } else {
                $this->command->warn("⚠️ Failed to download photo for: {$product->name} from {$url}");
            }
        } catch (\Exception $e) {
            $this->command->error("❌ Error downloading photo for {$product->name}: " . $e->getMessage());
        }
    }
}
