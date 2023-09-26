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
        Schema::table('greeting_companies', function (Blueprint $table) {
            $table->foreignId('company_id')->after('message_company')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('greeting_companies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
        });
    }
};
