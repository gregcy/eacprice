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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('code');
            $table->decimal('public_service_obligation', 7, 5);
            $table->decimal('recurring_supply_charge', 5, 2);
            $table->decimal('recurring_meter_reading', 5, 2);
            $table->decimal('energy_charge_normal', 5, 2);
            $table->decimal('energy_charge_reduced', 5, 2);
            $table->decimal('network_charge_normal', 5, 2);
            $table->decimal('network_charge_reduced', 5, 2);
            $table->decimal('ancilary_services_normal', 5, 2);
            $table->decimal('ancilary_services_reduced', 5, 2);
            $table->integer('consumption_from');
            $table->integer('consumption_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
