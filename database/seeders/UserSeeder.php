<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin TNI',
            'email' => 'admin@siremu.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin', 
        ]);

        // User biasa
        User::create([
            'name' => 'Prajurit User',
            'email' => 'user@siremu.id',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
