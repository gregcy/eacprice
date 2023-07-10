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
            $table->date('end_date')->nullable();
            $table->string('code');
            $table->decimal('public_service_obligation', 7, 5);
            $table->decimal('recurring_supply_charge', 5, 2)->nullable;
            $table->decimal('recurring_meter_reading', 5, 2)->nullable;
            $table->decimal('energy_charge_normal', 5, 2)->nullable;
            $table->decimal('energy_charge_reduced', 5, 2)->nullable;
            $table->decimal('network_charge_normal', 5, 2)->nullable;
            $table->decimal('network_charge_reduced', 5, 2)->nullable;
            $table->decimal('ancilary_services_normal', 5, 2)->nullable;
            $table->decimal('ancilary_services_reduced', 5, 2)->nullable;
            $table->decimal('energy_charge_subsidy_first', 5, 2)->nullable;
            $table->decimal('energy_charge_subsidy_second', 5, 2)->nullable;
            $table->decimal('energy_charge_subsidy_third', 5, 2)->nullable;
            $table->decimal('supply_subsidy_first', 5, 2)->nullable;
            $table->decimal('supply_subsidy_second', 5, 2)->nullable;
            $table->decimal('supply_subsidy_third', 5, 2)->nullable;
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
