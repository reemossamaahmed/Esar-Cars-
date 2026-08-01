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
        Schema::create('car_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('car_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Owner Identity
            |--------------------------------------------------------------------------
            */

            $table->string('owner_id_number');

            $table->date('owner_issue_date');

            $table->date('owner_expiry_date');

            $table->string('owner_front_image_url');

            $table->string('owner_back_image_url');
            /*
            |--------------------------------------------------------------------------
            | Car Registration
            |--------------------------------------------------------------------------
            */
            $table->string('plate_number');

            $table->date('registration_issue_date');

            $table->date('registration_expiry_date');

            $table->string('registration_front_image_url');

            $table->string('registration_back_image_url');

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */
            $table->enum('verification_status', [

                'pending',

                'approved',

                'rejected',

            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            $table->unique('car_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_documents');
    }
};
