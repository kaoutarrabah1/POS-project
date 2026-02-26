<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'Manager',
        'email' => 'manager@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'manager',
    ]);

    \App\Models\User::create([
        'name' => 'Client',
        'email' => 'client@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'client',
    ]);
}
}
