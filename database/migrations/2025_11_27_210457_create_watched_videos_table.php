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
        Schema::create('watched_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('date')->nullable();
            $table->foreignUuid('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->foreignUuid('section_video_id')->nullable()->constrained('section_videos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watched_videos');
    }
};
