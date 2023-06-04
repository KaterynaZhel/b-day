<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('celebrants', function (Blueprint $table) {
            $table->dropColumn('position');
        });

        Schema::table('celebrants', function (Blueprint $table) {
            $table->tinyInteger('position')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('celebrants', function (Blueprint $table) {
            $table->dropColumn('position');
        });
        Schema::table('celebrants', function (Blueprint $table) {
            $table->string('position')->nullable();
        });
    }
};