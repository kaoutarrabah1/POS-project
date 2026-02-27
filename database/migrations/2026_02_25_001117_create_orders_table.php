<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('type_commande'); // sur place, à emporter, livraison
        $table->string('statut')->default('en attente');
        $table->decimal('total', 10, 2);
        $table->timestamp('date_commande')->useCurrent();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
