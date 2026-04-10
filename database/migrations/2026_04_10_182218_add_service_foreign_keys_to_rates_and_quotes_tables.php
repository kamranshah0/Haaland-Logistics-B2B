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
        Schema::table('rates', function (Blueprint $table) {
            $table->foreignId('shipping_service_id')->nullable()->after('region_id')->constrained('shipping_services')->onDelete('set null');
            $table->foreignId('service_type_id')->nullable()->after('shipping_service_id')->constrained('service_types')->onDelete('set null');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('service_type_id')->nullable()->after('total_price')->constrained('service_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropForeign(['shipping_service_id']);
            $table->dropForeign(['service_type_id']);
            $table->dropColumn(['shipping_service_id', 'service_type_id']);
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['service_type_id']);
            $table->dropColumn('service_type_id');
        });
    }
};
