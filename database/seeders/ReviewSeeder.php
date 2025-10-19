<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get users and products
        $users = User::where('role', '!=', 'admin')->get();
        $products = Product::all();
        
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No users or products found. Please run UserSeeder and ProductSeeder first.');
            return;
        }
        
        // Get completed orders to ensure realistic reviews (people review what they bought)
        $completedOrderItems = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'completed');
        })->with(['order.user', 'product'])->get();
        
        // Review templates based on rating
        $reviewTemplates = [
            5 => [
                "Produk sangat bagus! Kualitas premium dan sesuai ekspektasi. Pasti akan beli lagi!",
                "Luar biasa! Pelayanan cepat dan produk berkualitas tinggi. Sangat puas dengan pembelian ini.",
                "Perfect! Packaging rapi, pengiriman cepat, dan kualitas produk excellent. Highly recommended!",
                "Produk original dan berkualitas. Seller responsif dan pengiriman super cepat. Top markotop!",
                "Kualitas produk sangat baik, sesuai deskripsi. Packaging aman dan rapi. Terima kasih!"
            ],
            4 => [
                "Produk bagus dan sesuai deskripsi. Packaging oke, pengiriman cepat. Recommended!",
                "Kualitas produk baik, hanya saja pengiriman agak lama. Overall satisfied with the purchase.",
                "Produk sesuai ekspektasi. Kualitas bagus dan harga reasonable. Good seller!",
                "Barang sampai dengan selamat. Kualitas produk bagus, tapi packaging bisa diperbaiki.",
                "Produk original dan berkualitas. Pelayanan ramah, cuma pengiriman agak delay."
            ],
            3 => [
                "Produk oke, sesuai harga. Pengiriman standar, tidak ada komplain berarti.",
                "Kualitas produk cukup baik. Ada sedikit perbedaan dengan foto, tapi masih acceptable.",
                "Barang sampai dengan aman. Kualitas sesuai harga, tidak terlalu istimewa tapi tidak mengecewakan.",
                "Produk standar, sesuai ekspektasi. Packaging biasa aja, pengiriman normal.",
                "Cukup puas dengan pembelian ini. Produk sesuai deskripsi, tapi bisa lebih baik lagi."
            ],
            2 => [
                "Produk kurang sesuai ekspektasi. Kualitas biasa aja, harga agak mahal untuk kualitas segini.",
                "Barang sampai tapi ada sedikit cacat. Packaging kurang rapi, agak kecewa.",
                "Produk tidak sesuai foto. Kualitas dibawah ekspektasi, tapi masih bisa dipakai.",
                "Pengiriman lama dan packaging kurang aman. Produk oke tapi pelayanan perlu diperbaiki.",
                "Kualitas produk biasa, tidak seistimewa yang diharapkan. Harga tidak sebanding."
            ],
            1 => [
                "Sangat kecewa dengan produk ini. Kualitas jauh dari ekspektasi, tidak recommended.",
                "Barang tidak sesuai deskripsi. Kualitas buruk dan packaging rusak. Mohon diperbaiki.",
                "Produk cacat dan pengiriman sangat lama. Pelayanan tidak memuaskan.",
                "Kualitas produk sangat mengecewakan. Tidak worth it sama sekali dengan harga yang dibayar.",
                "Barang rusak saat sampai dan seller tidak responsif. Sangat tidak puas!"
            ]
        ];
        
        // Create reviews for about 60% of completed order items
        $reviewableItems = $completedOrderItems->shuffle()->take(
            (int) ($completedOrderItems->count() * 0.6)
        );
        
        foreach ($reviewableItems as $orderItem) {
            $user = $orderItem->order->user;
            $product = $orderItem->product;
            
            // Generate rating (weighted towards higher ratings - realistic e-commerce pattern)
            $rating = $faker->randomElement([5, 5, 5, 4, 4, 4, 3, 3, 2, 1]);
            
            // Get random review text for this rating
            $reviewText = $faker->randomElement($reviewTemplates[$rating]);
            
            // Create review date after order completion (realistic timeline)
            $orderDate = $orderItem->order->created_at;
            $reviewDate = $orderDate->addDays($faker->numberBetween(1, 30));
            
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $rating,
                'comment' => $reviewText,
                'created_at' => $reviewDate,
                'updated_at' => $reviewDate,
            ]);
        }
        
        // Add some additional random reviews (for products without order history)
        $additionalReviews = 20;
        for ($i = 0; $i < $additionalReviews; $i++) {
            $user = $users->random();
            $product = $products->random();
            
            // Check if this user already reviewed this product
            $existingReview = Review::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
                
            if ($existingReview) {
                continue; // Skip if already reviewed
            }
            
            $rating = $faker->randomElement([5, 5, 4, 4, 4, 3, 3, 2, 1]);
            $reviewText = $faker->randomElement($reviewTemplates[$rating]);
            
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $rating,
                'comment' => $reviewText,
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-2 months', 'now'),
            ]);
        }
        
        $reviewCount = Review::count();
        $this->command->info("✅ Reviews seeded successfully!");
        $this->command->info("📊 Created {$reviewCount} product reviews");
        
        // Show review statistics
        $this->showReviewStats();
    }
    
    /**
     * Show review statistics
     */
    private function showReviewStats()
    {
        $this->command->info('');
        $this->command->info('📈 Review Rating Distribution:');
        
        $ratingCounts = Review::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();
            
        foreach ($ratingCounts as $ratingCount) {
            $stars = str_repeat('⭐', $ratingCount->rating);
            $this->command->info("   {$stars} ({$ratingCount->rating}): {$ratingCount->count} reviews");
        }
        
        $avgRating = Review::avg('rating');
        $this->command->info('');
        $this->command->info('📊 Average Rating: ' . number_format($avgRating, 2) . ' / 5.0');
        
        // Show products with most reviews
        $topReviewedProducts = Product::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(5)
            ->get();
            
        if ($topReviewedProducts->isNotEmpty()) {
            $this->command->info('');
            $this->command->info('🏆 Top Reviewed Products:');
            foreach ($topReviewedProducts as $product) {
                $this->command->info("   📦 {$product->name}: {$product->reviews_count} reviews");
            }
        }
    }
}
