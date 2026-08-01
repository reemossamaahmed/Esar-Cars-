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
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Base Prices
            |--------------------------------------------------------------------------
            */

            $table->decimal('daily_price', 10, 2);

            $table->decimal('monthly_price', 10, 2)
                ->nullable();

            $table->decimal('yearly_price', 10, 2)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Booking
            |--------------------------------------------------------------------------
            */

            $table->boolean('instant_booking_enabled')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Deposit
            |--------------------------------------------------------------------------
            */

            $table->string('deposit_title')
                ->nullable();

            $table->text('deposit_description')
                ->nullable();

            $table->decimal('deposit_price', 10, 2)
                ->nullable();


            $table->timestamps();

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
