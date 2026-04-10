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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Client
            $table->string('booking_number')->unique();
            $table->datetime('drop_off_date');
            $table->string('status')->default('scheduled'); // scheduled, received, shipped, delivered
            $table->foreignId('departure_id')->nullable(); // Assigned during ops planning
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
