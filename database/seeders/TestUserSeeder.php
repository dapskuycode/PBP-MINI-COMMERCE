<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create buyer user for easy login testing
        User::updateOrCreate(
            ['email' => 'buyer@minicommerce.com'],
            [
                'name' => 'Buyer User',
                'email' => 'buyer@minicommerce.com',
                'password' => Hash::make('password123'),
                'role' => 'buyer'
            ]
        );

        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@minicommerce.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@minicommerce.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // Update existing users to have proper roles
        User::where('role', 'user')->update(['role' => 'buyer']);
    }
}
