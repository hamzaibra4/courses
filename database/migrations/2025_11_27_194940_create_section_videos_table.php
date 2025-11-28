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
        Schema::create('section_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('path')->nullable();
            $table->integer('item_index')->nullable();
            $table->foreignUuid('section_id')->nullable()->constrained('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_videos');
    }
};
