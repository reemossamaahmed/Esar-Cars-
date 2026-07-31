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
            | Registration
            |--------------------------------------------------------------------------
            */

            $table->string('license_number');

            $table->string('insurance_policy_number');

            $table->date('issue_date');

            $table->date('expiry_date');


            /*
            |--------------------------------------------------------------------------
            | File
            |--------------------------------------------------------------------------
            */

            $table->string('vehicle_document_url');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique('car_id');

            $table->index('license_number');

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
