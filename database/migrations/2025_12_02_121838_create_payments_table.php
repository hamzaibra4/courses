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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('student_id');
            $table->uuid('enrolled_course_id');
            $table->string('date');
            $table->double('amount');
            $table->string('trx_number');
            $table->integer('counter')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('enrolled_course_id')->references('id')->on('enrolled_courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
