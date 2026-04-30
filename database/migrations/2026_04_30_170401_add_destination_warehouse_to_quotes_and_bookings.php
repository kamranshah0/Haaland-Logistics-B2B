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
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['destination_warehouse_id']);
            $table->dropColumn('destination_warehouse_id');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['destination_warehouse_id']);
            $table->dropColumn('destination_warehouse_id');
        });
    }
};
