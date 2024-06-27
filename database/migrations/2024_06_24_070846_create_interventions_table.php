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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_interv')->nullable();
            $table->timestamp('end_interv')->nullable();
            $table->timestamp('start_incident')->nullable();
            $table->timestamp('restore_date')->nullable();
            $table->integer('downtime_resolution')->nullable();
            $table->integer('intervention_duration')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->float('kpi_intervention')->nullable();
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('intervention_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('intervention_id');
        });
        Schema::dropIfExists('interventions');
    }
};
