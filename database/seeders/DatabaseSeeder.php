<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleUserSeeder::class,    // المستخدمين
            CategorySeeder::class,    // التصنيفات
            TableSeeder::class,       // الطاولات
            MenuItemSeeder::class,    // عناصر القائمة (يحتاج categories)
            StockSeeder::class,       // المخزون (يحتاج menu_items)
            OrderSeeder::class,       // الطلبات (يحتاج client و menu_items)
            ReservationSeeder::class, // الحجوزات (يحتاج client و tables)
            PaymentSeeder::class,     // المدفوعات (يحتاج orders)
        ]);
    }
}
