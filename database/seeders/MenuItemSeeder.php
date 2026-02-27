<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // افترض أن categories IDs: 1=Pizzas, 2=Burgers, 3=Salades, 4=Boissons, 5=Desserts, 6=Pâtes, 7=Tacos, 8=Entrées
        $items = [
            // Pizzas
            ['name' => 'Margherita', 'description' => 'Sauce tomate, mozzarella, basilic', 'price' => 45.00, 'category_id' => 1],
            ['name' => 'Reine', 'description' => 'Sauce tomate, jambon, champignons, fromage', 'price' => 55.00, 'category_id' => 1],
            ['name' => '4 Fromages', 'description' => 'Mozzarella, gorgonzola, parmesan, chèvre', 'price' => 65.00, 'category_id' => 1],
            // Burgers
            ['name' => 'Classic', 'description' => 'Steak, salade, tomate, oignon, sauce burger', 'price' => 40.00, 'category_id' => 2],
            ['name' => 'Cheese', 'description' => 'Double steak, cheddar, bacon, sauce barbecue', 'price' => 55.00, 'category_id' => 2],
            // Salades
            ['name' => 'César', 'description' => 'Poulet, laitue, parmesan, croûtons, sauce césar', 'price' => 48.00, 'category_id' => 3],
            ['name' => 'Niçoise', 'description' => 'Thon, œuf dur, tomates, olives, haricots verts', 'price' => 52.00, 'category_id' => 3],
            // Boissons
            ['name' => 'Coca-Cola', 'description' => '33cl', 'price' => 12.00, 'category_id' => 4],
            ['name' => 'Eau minérale', 'description' => '50cl', 'price' => 8.00, 'category_id' => 4],
            ['name' => 'Jus d\'orange', 'description' => 'Frais', 'price' => 15.00, 'category_id' => 4],
            // Desserts
            ['name' => 'Tiramisu', 'description' => 'Fait maison', 'price' => 25.00, 'category_id' => 5],
            ['name' => 'Fondant au chocolat', 'description' => 'Cœur coulant', 'price' => 28.00, 'category_id' => 5],
            // Pâtes
            ['name' => 'Carbonara', 'description' => 'Sauce carbonara, lardons, parmesan', 'price' => 58.00, 'category_id' => 6],
            ['name' => 'Bolognaise', 'description' => 'Sauce bolognaise maison', 'price' => 55.00, 'category_id' => 6],
            // Tacos
            ['name' => 'Tacos Poulet', 'description' => 'Poulet, frites, fromage, sauce blanche', 'price' => 42.00, 'category_id' => 7],
            ['name' => 'Tacos Mixte', 'description' => 'Viande hachée, poulet, frites, fromage', 'price' => 48.00, 'category_id' => 7],
            // Entrées
            ['name' => 'Bruschetta', 'description' => 'Tomates fraîches, ail, basilic', 'price' => 22.00, 'category_id' => 8],
            ['name' => 'Œufs mayonnaise', 'description' => 'Maison', 'price' => 18.00, 'category_id' => 8],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }

        $this->command->info('✅ Menu items ajoutés.');
    }
}