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
        Schema::create('jotting_shares', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('jotting_id');
            $table->uuid('shared_with');
            $table->enum('permission', ['view', 'edit'])->default('view');

            $table->timestamps();

            $table->unique(['jotting_id', 'shared_with']);

            $table->foreign('jotting_id')->references('id')->on('jottings')->cascadeOnDelete();
            $table->foreign('shared_with')->references('id')->on('users')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jotting_shares');
    }
};
