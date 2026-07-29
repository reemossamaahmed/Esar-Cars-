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
        Schema::create('car_models', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('brand_id')->constrained('brands')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('name');

            $table->string('slug');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['brand_id', 'name']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
