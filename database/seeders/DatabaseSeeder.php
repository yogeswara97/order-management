<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Yoges',
            'email' => 'yoges@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super.admin'
        ]);
        User::create([
            'name' => 'Yoges',
            'email' => 'yoges2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Customer::factory()->count(20)->create();

        // Order::factory()->count(3)->create();
        // OrderItem::factory()->count(20)->withOrderId(1)->create();
    }
}
