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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('brand', 100)->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->decimal('cost_price', 12, 2);
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
            
            $table->index(['category_id', 'brand', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
