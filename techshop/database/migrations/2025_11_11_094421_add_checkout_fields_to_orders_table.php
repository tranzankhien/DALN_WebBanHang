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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_city', 100)->nullable()->after('shipping_address');
            $table->string('shipping_district', 100)->nullable()->after('shipping_city');
            $table->string('shipping_ward', 100)->nullable()->after('shipping_district');
            $table->text('customer_note')->nullable()->after('shipping_ward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_city', 'shipping_district', 'shipping_ward', 'customer_note']);
        });
    }
};
