<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contribution_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('contribution_id');

            $table->enum('type', ['text', 'voice', 'sketch']);
            $table->longText('content')->nullable(); // text OR file path
            $table->json('metadata')->nullable();    // duration, size, etc

            $table->timestamps();

            $table->foreign('contribution_id')
                  ->references('id')
                  ->on('contributions')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_items');
    }
};
