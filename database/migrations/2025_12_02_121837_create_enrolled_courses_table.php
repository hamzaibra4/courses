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
        Schema::create('enrolled_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('enrollment_number');
            $table->uuid('student_id');
            $table->uuid('status_id')->nullable();
            $table->double('total_amount')->default(0);
            $table->double('received_amount')->default(0);
            $table->double('remaining_amount')->default(0);
            $table->integer('counter')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('related_courses_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolled_courses');
    }
};
