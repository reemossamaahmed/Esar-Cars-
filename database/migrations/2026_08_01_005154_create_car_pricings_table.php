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
        Schema::create('car_pricings', function (Blueprint $table) {

            $table->id();


            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Base Prices
            |--------------------------------------------------------------------------
            */

            $table->decimal('daily_price', 10, 2);

            $table->decimal('weekly_price', 10, 2)
                ->nullable();

            $table->decimal('monthly_price', 10, 2)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            $table->decimal('down_payment', 10, 2)
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | Booking
            |--------------------------------------------------------------------------
            */

            $table->boolean('instant_booking_enabled')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $table->string('currency', 3)
                ->default('SAR');


            $table->timestamps();


            $table->unique('car_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_pricings');
    }
};
