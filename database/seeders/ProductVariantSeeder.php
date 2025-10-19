<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('⚠️ No products found. Please run ProductSeeder first.');
            return;
        }
        
        // Define variant types based on product categories
        $colorVariants = [
            'Merah', 'Biru', 'Hijau', 'Kuning', 'Putih', 'Hitam', 
            'Coklat', 'Pink', 'Ungu', 'Orange', 'Abu-abu'
        ];
        
        $sizeVariants = [
            'XS', 'S', 'M', 'L', 'XL', 'XXL'
        ];
        
        $flavorVariants = [
            'Original', 'Pedas', 'Manis', 'Asin', 'Gurih', 
            'Keju', 'BBQ', 'Balado', 'Rendang', 'Sate'
        ];
        
        $packagingVariants = [
            '100g', '250g', '500g', '1kg', 
            '200ml', '500ml', '1L',
            'Kecil', 'Sedang', 'Besar'
        ];
        
        foreach ($products as $product) {
            $categoryName = $product->category->name ?? '';
            $variants = [];
            
            // Determine variants based on category
            switch ($categoryName) {
                case 'Aksesoris & Souvenir':
                    // Clothing items get size and color variants
                    if (str_contains($product->name, 'Kaos')) {
                        $variants = [
                            ['type' => 'size', 'options' => $sizeVariants],
                            ['type' => 'color', 'options' => $colorVariants]
                        ];
                    } else {
                        // Other accessories get color variants
                        $variants = [
                            ['type' => 'color', 'options' => array_slice($colorVariants, 0, 4)]
                        ];
                    }
                    break;
                    
                case 'Makanan':
                case 'Makanan Khas Daerah':
                    // Food items get flavor and size variants
                    $variants = [
                        ['type' => 'rasa', 'options' => array_slice($flavorVariants, 0, 3)],
                        ['type' => 'kemasan', 'options' => array_slice($packagingVariants, 0, 3)]
                    ];
                    break;
                    
                case 'Minuman Manis':
                    // Drinks get size variants
                    $variants = [
                        ['type' => 'kemasan', 'options' => ['200ml', '500ml', '1L']]
                    ];
                    break;
                    
                case 'Kemasan':
                    // Packaging items get size variants
                    $variants = [
                        ['type' => 'ukuran', 'options' => ['Kecil', 'Sedang', 'Besar']]
                    ];
                    break;
            }
            
            // Create variants for this product
            foreach ($variants as $variant) {
                $selectedOptions = $faker->randomElements(
                    $variant['options'], 
                    $faker->numberBetween(2, min(4, count($variant['options'])))
                );
                
                foreach ($selectedOptions as $option) {
                    // Calculate variant price (base price ± 10-30%)
                    $priceMultiplier = $faker->randomFloat(2, 0.8, 1.3);
                    $variantPrice = round($product->price * $priceMultiplier);
                    
                    // Ensure minimum price of 5000
                    $variantPrice = max(5000, $variantPrice);
                    
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => ucfirst($variant['type']) . ': ' . $option,
                        'additional_price' => $variantPrice - $product->price,
                        'stock' => $faker->numberBetween(5, 25),
                    ]);
                }
            }
        }
        
        $variantCount = ProductVariant::count();
        $this->command->info("✅ ProductVariant seeded successfully!");
        $this->command->info("📊 Created {$variantCount} product variants");
        
        // Show variant distribution
        $this->showVariantDistribution();
    }
    
    /**
     * Show variant type distribution
     */
    private function showVariantDistribution()
    {
        $this->command->info('');
        $this->command->info('📈 Product Variant Distribution:');
        
        // Extract variant types from name field (format: "Type: Value")
        $variants = ProductVariant::select('name')->get();
        $typeCounts = [];
        
        foreach ($variants as $variant) {
            if (strpos($variant->name, ':') !== false) {
                $type = trim(explode(':', $variant->name)[0]);
                $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;
            }
        }
            
        foreach ($typeCounts as $type => $count) {
            $emoji = $this->getVariantEmoji(strtolower($type));
            $this->command->info("   {$emoji} {$type}: {$count} variants");
        }
    }
    
    /**
     * Get emoji for variant type
     */
    private function getVariantEmoji(string $type): string
    {
        return match($type) {
            'size' => '📏',
            'color' => '🎨',
            'rasa' => '👅',
            'kemasan' => '📦',
            'ukuran' => '📐',
            default => '🔧'
        };
    }
}
