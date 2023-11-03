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
        Schema::table(
            'tariffs', function (Blueprint $table) {
                $table->dropColumn('public_service_obligation');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'tariffs', function (Blueprint $table) {
                $table->decimal('public_service_obligation', 7, 5);
            }
        );
    }
};
