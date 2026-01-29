<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@cloudtech.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
            'role' => 'admin',
            'phone' => '0240000000',
            'is_active' => true,
        ]);
    }
}
