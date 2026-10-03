<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Booking Reference
            |--------------------------------------------------------------------------
            */

            $table->string('booking_number')->unique();


            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->foreignUuid('car_id')
                ->constrained('cars')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('renter_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            /*
            |--------------------------------------------------------------------------
            | Pickup / Dropoff
            |--------------------------------------------------------------------------
            */

            $table->foreignId('pickup_city_id')
                ->constrained('cities')
                ->restrictOnDelete();

            $table->foreignId('dropoff_city_id')
                ->constrained('cities')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Booking Period
            |--------------------------------------------------------------------------
            */

            $table->dateTime('pickup_at');

            $table->dateTime('dropoff_at');


            /*
            |--------------------------------------------------------------------------
            | Booking Status
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'status',
                array_column(BookingStatus::cases(), 'value')
            )->default(BookingStatus::PENDING->value);


            /*
            |--------------------------------------------------------------------------
            | Price Snapshot
            |--------------------------------------------------------------------------
            */

            $table->decimal('base_amount', 10, 2)
                ->default(0);

            $table->decimal('custom_price_adjustment', 10, 2)
                ->default(0);

            $table->decimal('discount_amount', 10, 2)
                ->default(0);

            $table->decimal('pickup_fee', 10, 2)
                ->default(0);

            $table->decimal('dropoff_fee', 10, 2)
                ->default(0);

            $table->decimal('delivery_fee', 10, 2)
                ->default(0);

            $table->decimal('deposit_amount', 10, 2)
                ->default(0);

            $table->decimal('total_amount', 10, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'payment_method',
                array_column(PaymentMethod::cases(), 'value')
            );

            $table->enum(
                'payment_status',
                array_column(PaymentStatus::cases(), 'value')
            )->default(PaymentStatus::PENDING->value);


            /*
            |--------------------------------------------------------------------------
            | Cancellation
            |--------------------------------------------------------------------------
            */

            $table->text('cancellation_reason')
                ->nullable();

            $table->timestamp('cancelled_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Confirmation / Completion
            |--------------------------------------------------------------------------
            */

            $table->timestamp('confirmed_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'car_id',
                'pickup_at',
                'dropoff_at',
            ]);

            $table->index([
                'renter_id',
                'status',
            ]);

            $table->index('pickup_city_id');

            $table->index('dropoff_city_id');

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
