<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TableResto;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['numero' => 1, 'capacite' => 2, 'statut' => 'libre'],
            ['numero' => 2, 'capacite' => 2, 'statut' => 'libre'],
            ['numero' => 3, 'capacite' => 4, 'statut' => 'libre'],
            ['numero' => 4, 'capacite' => 4, 'statut' => 'libre'],
            ['numero' => 5, 'capacite' => 6, 'statut' => 'libre'],
            ['numero' => 6, 'capacite' => 6, 'statut' => 'libre'],
            ['numero' => 7, 'capacite' => 8, 'statut' => 'libre'],
            ['numero' => 8, 'capacite' => 8, 'statut' => 'libre'],
            ['numero' => 9, 'capacite' => 10, 'statut' => 'libre'],
            ['numero' => 10, 'capacite' => 12, 'statut' => 'libre'],
        ];

        foreach ($tables as $table) {
            TableResto::create($table);
        }

        $this->command->info('✅ Tables ajoutées.');
    }
}