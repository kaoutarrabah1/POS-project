<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\MenuItem;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // نجيب client (user id = 3 مثلاً)
        $client = User::where('role', 'client')->first();
        if (!$client) {
            $this->command->error('❌ Aucun client trouvé. Exécute d\'abord RoleUserSeeder.');
            return;
        }

        // نجيب بعض menu items
        $items = MenuItem::inRandomOrder()->limit(5)->get();

        // ننشئ طلبين للعميل
        for ($i = 0; $i < 2; $i++) {
            $total = 0;
            $order = Order::create([
                'user_id' => $client->id,
                'type_commande' => ['sur place', 'à emporter', 'livraison'][rand(0, 2)],
                'statut' => ['en attente', 'confirmé', 'préparé', 'livré', 'payé'][rand(0, 4)],
                'total' => 0,
                'date_commande' => now()->subDays(rand(1, 10)),
            ]);

            // نضيف من 2 إلى 4 items
            $selectedItems = $items->random(rand(2, 4));
            foreach ($selectedItems as $item) {
                $qty = rand(1, 3);
                $price = $item->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item->id,
                    'quantite' => $qty,
                    'prix' => $price,
                ]);
                $total += $price * $qty;
            }

            $order->update(['total' => $total]);
        }

        $this->command->info('✅ Commandes de test créées.');
    }
}