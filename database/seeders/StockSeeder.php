<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\MenuItem;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // لكل عنصر قائمة، نضيف مخزون أولي (كمية عشوائية)
        $menuItems = MenuItem::all();
        foreach ($menuItems as $item) {
            Stock::create([
                'menu_item_id' => $item->id,
                'quantite' => rand(10, 50), // كمية أولية بين 10 و 50
            ]);
        }

        $this->command->info('✅ Stocks ajoutés pour tous les menu items.');
    }
}