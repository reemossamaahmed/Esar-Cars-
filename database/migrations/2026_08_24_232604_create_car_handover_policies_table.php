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
        Schema::create('car_handover_policies', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Car
            |--------------------------------------------------------------------------
            */

            $table->foreignUuid('car_id')
                ->unique()
                ->constrained('cars')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Pickup
            |--------------------------------------------------------------------------
            */

            $table->enum('pickup_method', [
                'renter_pickup',
                'owner_delivery',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Drop-off
            |--------------------------------------------------------------------------
            */

            $table->enum('dropoff_method', [
                'renter_return',
                'owner_pickup',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Delivery Fees
            |--------------------------------------------------------------------------
            */

            $table->decimal('pickup_fee', 10, 2)->default(0);

            $table->decimal('dropoff_fee', 10, 2)->default(0);


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_handover_policies');
    }
};
