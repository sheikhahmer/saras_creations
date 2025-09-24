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
            $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete();
            $table->decimal('manufacturing_cost_per_kg', 14, 4);
            $table->decimal('total_manufacturing_cost', 16, 2)->nullable();
            $table->decimal('final_cost', 16, 2)->nullable();
            $table->decimal('wastage_kg', 12, 3)->default(0);
            $table->decimal('net_stock_kg', 12, 3)->nullable();
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
