<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manufacturings', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer');

            $table->decimal('quantity', 8, 2); // in KG
            $table->decimal('cost_per_kg', 10, 2);
            $table->decimal('total_cost', 12, 2)->virtualAs('quantity * cost_per_kg'); // auto-calculated

            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->storedAs('total_cost - paid_amount'); // auto-calc stored

            $table->date('manufactured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturings');
    }
};
