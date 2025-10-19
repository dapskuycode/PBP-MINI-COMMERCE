<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nomor_hp' => '081234567890',
            'alamat_default' => 'Jl. Admin No. 1, Jakarta Pusat, DKI Jakarta',
        ]);

        // Test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'nomor_hp' => '081234567891',
            'alamat_default' => 'Jl. Test No. 2, Jakarta Selatan, DKI Jakarta',
        ]);

        // Moderator user
        User::create([
            'name' => 'Moderator User',
            'email' => 'mod@example.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'nomor_hp' => '081234567892',
            'alamat_default' => 'Jl. Moderator No. 3, Jakarta Barat, DKI Jakarta',
        ]);
        
        // Create 20 additional regular users
        for ($i = 1; $i <= 20; $i++) {
            $name = $faker->name;
            $email = strtolower(str_replace(' ', '.', $name)) . $i . '@example.com';
            
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'user',
                'nomor_hp' => '08' . $faker->numerify('##########'),
                'alamat_default' => $faker->address,
            ]);
        }
        
        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('📊 Created ' . User::count() . ' users total');
        $this->command->info('   👑 Admin: 1');
        $this->command->info('   🛡️ Moderator: 1');
        $this->command->info('   👤 Regular Users: ' . User::where('role', 'user')->count());
    }
}
