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
        Schema::create('diary_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diary_id')->constrained()->onDelete('cascade');
            $table->string('mood');
            $table->tinyInteger('mood_score')->nullable();
            $table->text('reflection')->nullable();
            $table->text('habit_insight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_analyses');
    }
};
