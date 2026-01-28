<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('jotting_id');
            $table->uuid('contributor_id');

            $table->enum('status', ['pending', 'accepted', 'rejected'])
                  ->default('pending');

            $table->text('message')->nullable(); // optional note from contributor

            $table->uuid('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->foreign('jotting_id')->references('id')->on('jottings')->cascadeOnDelete();
            $table->foreign('contributor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
