<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get all existing orders
        $orders = Order::all();
        
        // Get available products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found! Please run ProductSeeder first.');
            return;
        }
        
        foreach ($orders as $order) {
            // Random number of items per order (1-4 items)
            $itemCount = rand(1, 4);
            $orderTotal = 0;
            
            for ($i = 0; $i < $itemCount; $i++) {
                // Get random product
                $product = $products->random();
                
                // Random quantity (1-5)
                $quantity = rand(1, 5);
                
                // Use product price or random price between 50000-500000
                $price = $product->price ?? rand(50000, 500000);
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                
                $orderTotal += ($price * $quantity);
            }
            
            // Update order total based on actual items
            $order->update(['total' => $orderTotal]);
        }
        
        $this->command->info('OrderItem seeder completed successfully!');
        $this->command->info('Created order items for ' . $orders->count() . ' orders.');
    }
}