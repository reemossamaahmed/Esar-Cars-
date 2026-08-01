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
        Schema::create('car_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->date('date_from');


            $table->date('date_to')->nullable();


            $table->enum('status', [

                'paused',

                'unavailable',

            ]);


            $table->enum('reason', [

                'maintenance',

                'temporarily_unavailable',

                'rented_elsewhere',

                'sold',

                'other',

            ])->nullable();


            $table->text('note')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_availabilities');
    }
};
