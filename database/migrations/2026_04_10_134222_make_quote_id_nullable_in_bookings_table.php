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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('quote_id')->nullable()->change();
            
            // Adding fields for external shipments
            $table->string('external_reference')->nullable();
            $table->decimal('external_volume_cft', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('quote_id')->nullable(false)->change();
            $table->dropColumn(['external_reference', 'external_volume_cft']);
        });
    }
};
