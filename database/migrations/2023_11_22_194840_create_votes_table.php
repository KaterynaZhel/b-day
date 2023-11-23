<?php

use App\Enums\VoteStatus;
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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->enum('status', array_column(VoteStatus::cases(), 'value'));
            $table->foreignId('celebrant_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('gift_id')
                ->constrained()
                ->onUpdate('cascade');
            $table->unsignedBigInteger('votes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
