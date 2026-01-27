<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jotting_id');
            $table->string('filename');
            $table->string('path');
            $table->enum('type', ['image', 'pdf', 'audio']);
            $table->timestamps();

            $table->foreign('jotting_id')->references('id')->on('jottings')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};

