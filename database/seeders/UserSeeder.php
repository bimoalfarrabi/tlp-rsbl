<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Super Admin',
        //     'password' => Hash::make('password123'),
        //     'role' => 'super_admin',
        // ]);

        // User::create([
        //     'name' => 'Admin',
        //     'password' => Hash::make('password123'),
        //     'role' => 'admin',
        // ]);

        // User::create([
        //     'name' => 'Humas',
        //     'password' => Hash::make('password123'),
        //     'role' => 'humas',
        // ]);
        User::create([
            'name' => 'Santoso',
            'password' => Hash::make('blambangan'),
            'role' => 'humas',
        ]);
    }
}
