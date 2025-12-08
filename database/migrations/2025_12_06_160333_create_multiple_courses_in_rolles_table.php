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
//        // Drop the old table if it exists with wrong name
//        Schema::dropIfExists('multiple_courses_in_rolleds');

        Schema::create('multiple_courses_in_rolles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('course_id');
            $table->uuid('in_rolled_course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('in_rolled_course_id')->references('id')->on('in_rolled_courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiple_courses_in_rolles');
    }
};
