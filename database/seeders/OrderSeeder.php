<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Indonesian locale
        
        // Get all users except admin
        $users = User::where('role', '!=', 'admin')->get();
        $products = Product::all();
        
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No users or products found. Please run UserSeeder and ProductSeeder first.');
            return;
        }
        
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $addresses = [
            'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220',
            'Jl. Gatot Subroto Kav. 56, Jakarta Selatan, DKI Jakarta 12950',
            'Jl. MH Thamrin No. 87, Jakarta Pusat, DKI Jakarta 10310',
            'Jl. HR Rasuna Said Blok X-5 Kav. 4-9, Jakarta Selatan, DKI Jakarta 12950',
            'Jl. Jend. Soedirman Kav. 52-53, Jakarta Selatan, DKI Jakarta 12190',
            'Jl. Kemang Raya No. 45, Jakarta Selatan, DKI Jakarta 12560',
            'Jl. Pantai Indah Kapuk Blvd, Jakarta Utara, DKI Jakarta 14470',
            'Jl. Kelapa Gading Boulevard, Jakarta Utara, DKI Jakarta 14240',
            'Jl. Puri Indah Raya, Jakarta Barat, DKI Jakarta 11610',
            'Jl. Cikini Raya No. 78, Jakarta Pusat, DKI Jakarta 10330'
        ];
        
        // Create 50 orders with realistic data
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $status = $faker->randomElement($statuses);
            
            // Create realistic order dates based on status
            $orderDate = null;
            switch ($status) {
                case 'pending':
                    // Pending orders are recent (last 2 days)
                    $orderDate = Carbon::now()->subMinutes(rand(0, 2880)); // 0-48 hours ago
                    break;
                case 'processing':
                    // Processing orders are 1-7 days old
                    $orderDate = Carbon::now()->subDays(rand(1, 7));
                    break;
                case 'shipped':
                    // Shipped orders are 2-14 days old
                    $orderDate = Carbon::now()->subDays(rand(2, 14));
                    break;
                case 'delivered':
                    // Delivered orders are 1-30 days old
                    $orderDate = Carbon::now()->subDays(rand(1, 30));
                    break;
                case 'cancelled':
                    // Cancelled orders can be from any time in last month
                    $orderDate = Carbon::now()->subDays(rand(1, 30));
                    break;
            }
            
            // Create the order first
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'address' => $faker->randomElement($addresses),
                'total' => 0, // Will be updated after adding items
                'created_at' => $orderDate,
                'updated_at' => $orderDate
            ]);
            
            // Add 1-5 random products to each order
            $orderTotal = 0;
            $numItems = $faker->numberBetween(1, 5);
            $selectedProducts = $products->random($numItems);
            
            foreach ($selectedProducts as $product) {
                $quantity = $faker->numberBetween(1, 3);
                $price = $product->price;
                $itemTotal = $price * $quantity;
                $orderTotal += $itemTotal;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate
                ]);
            }
            
            // Update order total
            $order->update(['total' => $orderTotal]);
        }
        
        $this->command->info('✅ Orders seeded successfully!');
        $this->command->info('📊 Created ' . Order::count() . ' orders with ' . OrderItem::count() . ' order items');
        
        // Show status distribution
        $this->showStatusDistribution();
    }
    
    /**
     * Get realistic created date based on order status
     */
    private function getCreatedDateByStatus(string $status, $faker)
    {
        $now = now();
        
        switch ($status) {
            case 'pending':
                // Recent orders (last 3 days)
                return $faker->dateTimeBetween('-3 days', 'now');
                
            case 'processing':
                // Orders from last week
                return $faker->dateTimeBetween('-7 days', '-1 day');
                
            case 'shipped':
                // Orders from last 2 weeks
                return $faker->dateTimeBetween('-14 days', '-3 days');
                
            case 'completed':
                // Orders from last month
                return $faker->dateTimeBetween('-30 days', '-7 days');
                
            case 'cancelled':
                // Random cancelled orders
                return $faker->dateTimeBetween('-60 days', '-1 day');
                
            default:
                return $faker->dateTimeBetween('-30 days', 'now');
        }
    }
    
    /**
     * Show order status distribution
     */
    private function showStatusDistribution()
    {
        $this->command->info('');
        $this->command->info('📈 Order Status Distribution:');
        
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
            
        foreach ($statusCounts as $statusCount) {
            $emoji = $this->getStatusEmoji($statusCount->status);
            $this->command->info("   {$emoji} {$statusCount->status}: {$statusCount->count} orders");
        }
        
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $this->command->info('');
        $this->command->info('💰 Total Revenue (Completed Orders): Rp ' . number_format($totalRevenue, 0, ',', '.'));
    }
    
    /**
     * Get emoji for order status
     */
    private function getStatusEmoji(string $status): string
    {
        return match($status) {
            'pending' => '⏳',
            'processing' => '🔄',
            'shipped' => '🚚',
            'completed' => '✅',
            'cancelled' => '❌',
            default => '📦'
        };
    }
}