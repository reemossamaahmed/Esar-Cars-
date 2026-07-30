<?php

use App\Enums\CustomPriceReason;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_custom_prices', function (Blueprint $table) {

            $table->id();

            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Custom Period
            |--------------------------------------------------------------------------
            */

            $table->date('date_from');

            $table->date('date_to');

            /*
            |--------------------------------------------------------------------------
            | Price
            |--------------------------------------------------------------------------
            */

            $table->decimal('daily_price', 10, 2);

            /*
            |--------------------------------------------------------------------------
            | Reason
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'reason',
                array_column(CustomPriceReason::cases(), 'value')
            )->default(CustomPriceReason::CUSTOM_PRICE->value);

            $table->timestamps();

            $table->index(['car_id']);

            $table->index(['date_from', 'date_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_custom_prices');
    }
};
