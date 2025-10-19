<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Seeders are run in dependency order:
     * 1. Users & Categories (independent)
     * 2. Products (depends on Categories)
     * 3. ProductVariants (depends on Products)
     * 4. Orders & OrderItems (depends on Users & Products)
     * 5. Reviews (depends on Users & Products)
     * 6. PhotoReviews (depends on Reviews)
     * 7. Carts (depends on Users)
     * 8. CartItems (depends on Carts & Products)
     * 9. FavoriteItems (depends on Users & Products)
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        $this->command->info('');
        
        // Phase 1: Core entities (independent)
        $this->command->info('📋 Phase 1: Seeding core entities...');
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        
        // Phase 2: Products and variants
        $this->command->info('');
        $this->command->info('🛍️ Phase 2: Seeding products and variants...');
        $this->call([
            ProductSeeder::class,
            ProductVariantSeeder::class,
        ]);
        
        // Phase 3: Orders and transactions
        $this->command->info('');
        $this->command->info('💰 Phase 3: Seeding orders and transactions...');
        $this->call([
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
        
        // Phase 4: Reviews and feedback
        $this->command->info('');
        $this->command->info('⭐ Phase 4: Seeding reviews and feedback...');
        $this->call([
            ReviewSeeder::class,
            PhotoReviewSeeder::class,
        ]);
        
        // Phase 5: Shopping experience
        $this->command->info('');
        $this->command->info('🛒 Phase 5: Seeding shopping experience...');
        $this->call([
            CartSeeder::class,
            CartItemSeeder::class,
            FavoriteItemSeeder::class,
        ]);
        
        $this->command->info('');
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('');
        
        // Final summary
        $this->showFinalSummary();
    }
    
    /**
     * Show final seeding summary
     */
    private function showFinalSummary()
    {
        $this->command->info('📊 SEEDING SUMMARY:');
        $this->command->info('═══════════════════════════════════════');
        
        // Get counts for each model
        $counts = [
            'Users' => \App\Models\User::count(),
            'Categories' => \App\Models\Category::count(),
            'Products' => \App\Models\Product::count(),
            'Product Variants' => \App\Models\ProductVariant::count(),
            'Item Photos' => \App\Models\ItemPhoto::count(),
            'Orders' => \App\Models\Order::count(),
            'Order Items' => \App\Models\OrderItem::count(),
            'Reviews' => \App\Models\Review::count(),
            'Photo Reviews' => \App\Models\PhotoReview::count(),
            'Carts' => \App\Models\Cart::count(),
            'Cart Items' => \App\Models\CartItem::count(),
            'Favorite Items' => \App\Models\FavoriteItem::count(),
        ];
        
        foreach ($counts as $label => $count) {
            $emoji = $this->getCountEmoji($label);
            $this->command->info("   {$emoji} {$label}: {$count}");
        }
        
        $this->command->info('');
        $this->command->info('🎉 Your e-commerce application now has comprehensive test data!');
        $this->command->info('💡 You can now test all features with realistic data relationships.');
    }
    
    /**
     * Get emoji for count display
     */
    private function getCountEmoji(string $label): string
    {
        return match(true) {
            str_contains($label, 'User') => '👥',
            str_contains($label, 'Categor') => '📂',
            str_contains($label, 'Product') => '🛍️',
            str_contains($label, 'Variant') => '🎨',
            str_contains($label, 'Photo') => '📸',
            str_contains($label, 'Order') => '💼',
            str_contains($label, 'Review') => '⭐',
            str_contains($label, 'Cart') => '🛒',
            str_contains($label, 'Favorite') => '❤️',
            default => '📦'
        };
    }
}
