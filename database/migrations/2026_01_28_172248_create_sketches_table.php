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
        Schema::create('sketches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jotting_id');
            $table->uuid('user_id');
            $table->json('data'); // canvas + strokes
            $table->timestamps();

            $table->foreign('jotting_id')->references('id')->on('jottings')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sketches');
    }
};
