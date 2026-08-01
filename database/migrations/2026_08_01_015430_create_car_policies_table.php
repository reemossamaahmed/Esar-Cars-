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
        Schema::create('car_policies', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Cancellation Policy
            |--------------------------------------------------------------------------
            */
            
            $table->unsignedInteger('cancellation_days')->default(0);


            $table->text('cancellation_details')->nullable();


            $table->timestamps();


            $table->unique('car_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_policies');
    }
};
