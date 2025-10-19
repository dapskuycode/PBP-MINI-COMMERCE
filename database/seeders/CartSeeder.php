<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all non-admin users
        $users = User::where('role', '!=', 'admin')->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('⚠️ No users found. Please run UserSeeder first.');
            return;
        }
        
        // Create carts for about 70% of users (realistic scenario - not all users have active carts)
        $usersWithCarts = $users->shuffle()->take(
            (int) ($users->count() * 0.7)
        );
        
        foreach ($usersWithCarts as $user) {
            // Check if user already has a cart
            $existingCart = Cart::where('user_id', $user->id)->first();
            
            if ($existingCart) {
                continue; // Skip if cart already exists
            }
            
            Cart::create([
                'user_id' => $user->id,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 week', 'now'),
            ]);
        }
        
        // Note: Guest carts not supported in current schema (user_id is required)
        
        $totalCarts = Cart::count();
        
        $this->command->info("✅ Carts seeded successfully!");
        $this->command->info("📊 Created {$totalCarts} user carts");
        
        // Show user cart penetration
        $totalUsers = $users->count();
        $cartPenetration = $totalUsers > 0 ? round(($totalCarts / $totalUsers) * 100, 1) : 0;
        $this->command->info("   📈 Cart penetration: {$cartPenetration}% of users have active carts");
    }
}
