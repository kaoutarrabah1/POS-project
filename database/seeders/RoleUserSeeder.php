<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@restaurant.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,  // 'admin'
        ]);

        // إنشاء مستخدم Manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@restaurant.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER, // 'manager'
        ]);

        // إنشاء مستخدم Client
        User::create([
            'name' => 'Client',
            'email' => 'client@restaurant.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CLIENT,  // 'client'
        ]);

        $this->command->info('✅ المستخدمون الافتراضيون تم إنشاؤهم بنجاح.');
    }
}