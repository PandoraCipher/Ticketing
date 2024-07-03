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
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('assigned');
            $table->unsignedBigInteger('assigned_id')->after('subject');
            $table->foreign('assigned_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['assigned_id']);
            $table->dropColumn('assigned_id');
            $table->string('assigned');
        });
    }
};
