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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference_number')->unique();
            $table->foreignId('origin_id')->constrained('warehouses');
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->decimal('volume_cbm', 10, 2);
            $table->decimal('volume_cft', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('service_type');
            $table->string('status')->default('draft'); // draft, confirmed, booking_requested
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
