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
        Schema::create('sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('document')->nullable();
            $table->integer('item_index')->nullable();
            $table->string('nb_of_hours')->nullable();
            $table->foreignUuid('chapter_id')->nullable()->constrained('chapters')->onDelete('cascade');
//            $table->foreignUuid('material_id')->nullable()->constrained('materials')->onDelete('cascade');
            $table->string('video_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
