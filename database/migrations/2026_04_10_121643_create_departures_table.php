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
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->string('vessel_name');
            $table->string('voyage_number');
            $table->date('cutoff_date');
            $table->date('departure_date');
            $table->date('arrival_date')->nullable();
            $table->decimal('capacity_cft', 12, 2);
            $table->string('status')->default('open'); // open, closed, shipped, arrived
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};
