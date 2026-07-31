<?php

use App\Enums\DocumentStatus;
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
        Schema::create('owner_documents', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Personal Information
            |--------------------------------------------------------------------------
            */

            $table->string('national_id', 30)->unique();

            $table->foreignId('issue_city_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('issue_date');

            $table->date('expiry_date');

            /*
            |--------------------------------------------------------------------------
            | Files
            |--------------------------------------------------------------------------
            */

            $table->string('id_card_image_url');

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->enum('status',array_column(DocumentStatus::cases(), 'value'))->default(DocumentStatus::PENDING->value);

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique('user_id');

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_documents');
    }
};
