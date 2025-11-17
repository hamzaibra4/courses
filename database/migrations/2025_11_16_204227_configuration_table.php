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
        Schema::create('configuration_tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('screen_name');
            $table->string('route');
            $table->string('model_name');
            $table->string('database_name');
            $table->boolean('has_translation')->default(false);
            $table->string('database_translation_name')->nullable();
            $table->string('relationchip_name')->nullable();
            $table->boolean('has_parent')->default(false);
            $table->string('parent_model')->nullable();
            $table->string('parent_key')->nullable();
            $table->boolean('has_image')->default(false);
            $table->boolean('has_additional_field1')->default(false);
            $table->string('additional_field1_name')->nullable();
            $table->boolean('has_additional_field2')->default(false);
            $table->string('additional_field2_name')->nullable();
            $table->string('icon_class')->nullable();
            $table->integer('item_index')->nullable();
            $table->boolean('has_add')->default(true);
            $table->boolean('has_delete')->default(true);
            $table->boolean('has_description')->default(false);
            $table->boolean('complex_description')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_tables');
    }
};
