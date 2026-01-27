<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jotting_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jotting_id');
            $table->uuid('edited_by'); // who edited
            $table->longText('content');
            $table->integer('version');
            $table->timestamps();

            // Foreign keys
            $table->foreign('jotting_id')->references('id')->on('jottings')->cascadeOnDelete();
            $table->foreign('edited_by')->references('id')->on('users')->cascadeOnDelete();

            $table->index(['jotting_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jotting_versions');
    }
};
