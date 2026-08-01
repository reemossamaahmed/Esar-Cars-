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
        Schema::create('car_discount_rules', function (Blueprint $table) {
            $table->id();


            $table->foreignId('car_pricing_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->string('title');


            $table->decimal('total_price', 10, 2);


            $table->unsignedSmallInteger('from_days');


            $table->unsignedSmallInteger('to_days');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_discount_rules');
    }
};
