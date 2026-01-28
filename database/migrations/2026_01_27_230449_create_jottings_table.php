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
        Schema::create('jottings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('course_id');
            $table->uuid('user_id'); // owner

            $table->string('title');
            $table->longText('content')->nullable();

            $table->string('voice_path')->nullable();
            $table->json('sketch_data')->nullable(); // canvas JSON

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jottings');
    }
};
