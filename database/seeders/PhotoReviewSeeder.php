<?php

namespace Database\Seeders;

use App\Models\PhotoReview;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class PhotoReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get reviews with rating 4 and 5 (customers are more likely to upload photos for good experiences)
        $goodReviews = Review::where('rating', '>=', 4)->get();
        
        if ($goodReviews->isEmpty()) {
            $this->command->warn('⚠️ No good reviews found. Please run ReviewSeeder first.');
            return;
        }
        
        // Select about 30% of good reviews to have photos
        $reviewsWithPhotos = $goodReviews->shuffle()->take(
            (int) ($goodReviews->count() * 0.3)
        );
        
        // Sample review photo URLs (using product-related images)
        $samplePhotoUrls = [
            'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600',
            'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600',
            'https://images.unsplash.com/photo-1544378730-6f3a9b7f6d78?w=600',
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600',
            'https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=600',
            'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600',
            'https://images.unsplash.com/photo-1546173159-315724a31696?w=600',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600',
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600',
            'https://images.unsplash.com/photo-1578849278619-e73505e9610f?w=600',
            'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=600',
            'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600',
            'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=600',
            'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600',
        ];
        
        foreach ($reviewsWithPhotos as $review) {
            // Each review can have 1-3 photos
            $numPhotos = $faker->numberBetween(1, 3);
            $selectedUrls = $faker->randomElements($samplePhotoUrls, $numPhotos);
            
            foreach ($selectedUrls as $index => $photoUrl) {
                $this->downloadAndSaveReviewPhoto($review, $photoUrl, $index);
            }
        }
        
        $photoCount = PhotoReview::count();
        $this->command->info("✅ PhotoReview seeded successfully!");
        $this->command->info("📊 Created {$photoCount} review photos for " . $reviewsWithPhotos->count() . " reviews");
        
        // Show statistics
        $this->showPhotoReviewStats();
    }
    
    /**
     * Download photo from URL and save to storage for review
     */
    private function downloadAndSaveReviewPhoto(Review $review, string $url, int $index = 0)
    {
        try {
            // Download image from URL
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                // Generate filename
                $extension = 'jpg'; // Default to jpg
                $filename = "review_{$review->id}_photo_{$index}.{$extension}";
                $path = "reviews/{$filename}";
                
                // Save to storage
                Storage::disk('public')->put($path, $response->body());
                
                // Create PhotoReview record
                PhotoReview::create([
                    'review_id' => $review->id,
                    'url' => $path,
                ]);
                
                $this->command->info("✅ Downloaded review photo for: {$review->product->name}");
            } else {
                $this->command->warn("⚠️ Failed to download review photo from {$url}");
            }
        } catch (\Exception $e) {
            $this->command->error("❌ Error downloading review photo: " . $e->getMessage());
        }
    }
    
    /**
     * Show photo review statistics
     */
    private function showPhotoReviewStats()
    {
        $this->command->info('');
        $this->command->info('📈 Photo Review Statistics:');
        
        // Reviews with photos
        $reviewsWithPhotosCount = Review::has('photos')->count();
        $totalReviews = Review::count();
        $percentage = $totalReviews > 0 ? round(($reviewsWithPhotosCount / $totalReviews) * 100, 1) : 0;
        
        $this->command->info("   📸 Reviews with photos: {$reviewsWithPhotosCount} / {$totalReviews} ({$percentage}%)");
        
        // Average photos per review (for reviews that have photos)
        $avgPhotosPerReview = PhotoReview::count() / max($reviewsWithPhotosCount, 1);
        $this->command->info("   📊 Average photos per review: " . number_format($avgPhotosPerReview, 1));
        
        // Products with photo reviews
        $productsWithPhotoReviews = Review::has('photos')
            ->distinct('product_id')
            ->count('product_id');
        $this->command->info("   🛍️ Products with photo reviews: {$productsWithPhotoReviews}");
    }
}
