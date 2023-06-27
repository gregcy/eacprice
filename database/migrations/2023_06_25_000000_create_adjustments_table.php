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
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('consumer_type');
            $table->decimal('weighted_average_fuel_price', 8, 4);
            $table->decimal('fuel_adjustment_coefficient', 8, 4);
            $table->string('voltage_type');
            $table->decimal('total', 8, 4);
            $table->decimal('fuel', 8, 4);
            $table->decimal('co2_emissions', 8, 4);
            $table->decimal('cosmos', 8, 4);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustments');
    }
};
