<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pizzas'],
            ['name' => 'Burgers'],
            ['name' => 'Salades'],
            ['name' => 'Boissons'],
            ['name' => 'Desserts'],
            ['name' => 'Pâtes'],
            ['name' => 'Tacos'],
            ['name' => 'Entrées'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $this->command->info('✅ Catégories ajoutées.');
    }
}