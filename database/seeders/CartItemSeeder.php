<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all carts and products
        $carts = Cart::all();
        $products = Product::all();
        
        if ($carts->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No carts or products found. Please run CartSeeder and ProductSeeder first.');
            return;
        }
        
        foreach ($carts as $cart) {
            // Each cart has 1-5 items (realistic shopping cart behavior)
            $numItems = $faker->numberBetween(1, 5);
            $selectedProducts = $products->random($numItems);
            
            foreach ($selectedProducts as $product) {
                // Check if this product is already in the cart
                $existingItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $product->id)
                    ->first();
                    
                if ($existingItem) {
                    continue; // Skip if product already in cart
                }
                
                // Realistic quantity distribution
                $quantity = $faker->randomElement([1, 1, 1, 2, 2, 3, 4, 5]); // Weighted towards 1-2 items
                
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'created_at' => $faker->dateTimeBetween($cart->created_at, 'now'),
                    'updated_at' => $faker->dateTimeBetween($cart->created_at, 'now'),
                ]);
            }
        }
        
        $cartItemCount = CartItem::count();
        $this->command->info("✅ CartItems seeded successfully!");
        $this->command->info("📊 Created {$cartItemCount} cart items");
        
        // Show cart statistics
        $this->showCartStats();
    }
    
    /**
     * Show cart statistics
     */
    private function showCartStats()
    {
        $this->command->info('');
        $this->command->info('📈 Cart Statistics:');
        
        // Average items per cart
        $totalItems = CartItem::count();
        $totalCarts = Cart::count();
        $avgItemsPerCart = $totalCarts > 0 ? round($totalItems / $totalCarts, 1) : 0;
        $this->command->info("   📦 Average items per cart: {$avgItemsPerCart}");
        
        // Carts with items vs empty carts
        $cartsWithItems = Cart::has('cartItems')->count();
        $emptyCarts = Cart::doesntHave('cartItems')->count();
        $this->command->info("   🛒 Carts with items: {$cartsWithItems}");
        $this->command->info("   🗑️ Empty carts: {$emptyCarts}");
        
        // Total cart items
        $totalCartItems = CartItem::sum('quantity');
        $this->command->info("   📦 Total items in all carts: {$totalCartItems}");
        
        // Most popular products in carts
        $popularProducts = Product::withCount('cartItems')
            ->orderBy('cart_items_count', 'desc')
            ->limit(3)
            ->get();
            
        if ($popularProducts->isNotEmpty()) {
            $this->command->info('');
            $this->command->info('🏆 Most Popular Products in Carts:');
            foreach ($popularProducts as $product) {
                $this->command->info("   🛍️ {$product->name}: {$product->cart_items_count} times added");
            }
        }
    }
}
