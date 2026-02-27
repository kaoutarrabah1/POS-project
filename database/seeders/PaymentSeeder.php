<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // نجيب الطلبات اللي ماعندهومش دفعة (payment)
        $orders = Order::doesntHave('payment')->get();

        if ($orders->isEmpty()) {
            $this->command->info('⚠️ ما كاينش طلبات بلا دفعات.');
            return;
        }

        foreach ($orders as $order) {
            // ندفع 50% من الطلبات فقط (اختياري)
            if (rand(0, 1)) {
                Payment::create([
                    'order_id' => $order->id,
                    'methode' => ['carte', 'espèces', 'autre'][rand(0, 2)],
                    'montant' => $order->total,
                    'statut' => 'payé',
                    'date_paiement' => now(),
                ]);

                // نحدث حالة الطلب إلى payé
                $order->update(['statut' => 'payé']);
            }
        }

        $this->command->info('✅ تم إنشاء مدفوعات تجريبية.');
    }
}