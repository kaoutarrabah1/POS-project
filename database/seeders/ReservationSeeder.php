<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\TableResto;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::where('role', 'client')->first();
        $tables = TableResto::all();

        if (!$client || $tables->isEmpty()) {
            $this->command->error('❌ Client ou tables manquants.');
            return;
        }

        // ننشئ 3 حجوزات
        for ($i = 0; $i < 3; $i++) {
            $table = $tables->random();
            Reservation::create([
                'user_id' => $client->id,
                'table_resto_id' => $table->id,
                'date' => now()->addDays(rand(1, 15))->format('Y-m-d'),
                'heure' => sprintf('%02d:00', rand(12, 21)), // 12h à 21h
                'nombre_personnes' => rand(1, $table->capacite),
                'statut' => ['confirmée', 'annulée', 'terminée'][rand(0, 2)],
            ]);
        }

        $this->command->info('✅ Réservations de test créées.');
    }
}