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
        Schema::create('rate_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rate_id')->constrained()->onDelete('cascade');
            $table->decimal('min_volume', 10, 2); // e.g., 0, 110, 170, 200, 350
            $table->decimal('price_per_cft', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_tiers');
    }
};
