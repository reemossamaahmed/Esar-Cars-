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
        Schema::create('car_locations', function (Blueprint $table) {

            $table->id();

            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('city_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('address')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();

            $table->unique('car_id');

            $table->index(['city_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_locations');
    }
};
