<?php

namespace Database\Seeders;

use App\Models\FavoriteItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FavoriteItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $users = User::where('role', '!=', 'admin')->get();
        $products = Product::all();
        
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No users or products found. Please run UserSeeder and ProductSeeder first.');
            return;
        }
        
        $usersWithFavorites = $users->shuffle()->take(
            (int) ($users->count() * 0.8)
        );
        
        foreach ($usersWithFavorites as $user) {
            $numFavorites = $faker->numberBetween(1, 8);
            $selectedProducts = $products->random($numFavorites);
            
            foreach ($selectedProducts as $product) {
                $existingFavorite = FavoriteItem::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();
                    
                if ($existingFavorite) {
                    continue; // Skip if already favorited
                }
                
                FavoriteItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                    'updated_at' => $faker->dateTimeBetween('-2 months', 'now'),
                ]);
            }
        }
        
        $favoriteCount = FavoriteItem::count();
        $this->command->info("✅ FavoriteItems seeded successfully!");
        $this->command->info("📊 Created {$favoriteCount} favorite items");
        
        $this->showFavoriteStats();
    }
    
   
    private function showFavoriteStats()
    {
        $this->command->info('');
        $this->command->info('📈 Favorite Statistics:');
        
        $usersWithFavorites = User::has('favoriteItems')->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $favoritesPenetration = $totalUsers > 0 ? round(($usersWithFavorites / $totalUsers) * 100, 1) : 0;
        
        $this->command->info("   👤 Users with favorites: {$usersWithFavorites} / {$totalUsers} ({$favoritesPenetration}%)");
        
        $avgFavoritesPerUser = $usersWithFavorites > 0 ? round(FavoriteItem::count() / $usersWithFavorites, 1) : 0;
        $this->command->info("   💝 Average favorites per user: {$avgFavoritesPerUser}");
        
        $mostFavorited = Product::withCount('favoriteItems')
            ->orderBy('favorite_items_count', 'desc')
            ->limit(5)
            ->get();
            
        if ($mostFavorited->isNotEmpty()) {
            $this->command->info('');
            $this->command->info('🏆 Most Favorited Products:');
            foreach ($mostFavorited as $product) {
                $this->command->info("   ❤️ {$product->name}: {$product->favorite_items_count} favorites");
            }
        }
        
        $favoritesByCategory = Product::join('favorite_items', 'products.id', '=', 'favorite_items.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as count')
            ->groupBy('categories.name')
            ->orderBy('count', 'desc')
            ->get();
            
        if ($favoritesByCategory->isNotEmpty()) {
            $this->command->info('');
            $this->command->info('📂 Favorites by Category:');
            foreach ($favoritesByCategory as $categoryFav) {
                $this->command->info("   📁 {$categoryFav->name}: {$categoryFav->count} favorites");
            }
        }
    }
}
