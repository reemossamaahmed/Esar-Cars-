<?php

use App\Enums\CarStatus;
use App\Enums\DrivetrainType;
use App\Enums\TransmissionType;
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
        Schema::create('cars', function (Blueprint $table) {

            // Primary Key
            $table->uuid('id')->primary();

            // Owner
            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // References
            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('car_model_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('car_type_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Basic Info
            $table->unsignedSmallInteger('year');

            $table->string('slug')->unique();

            $table->string('chassis_number')->unique();

            $table->unsignedTinyInteger('seats_count');

            $table->decimal('insurance_value', 12, 2);

            $table->enum(
                'transmission',
                array_column(TransmissionType::cases(), 'value')
            );

            $table->enum(
                'drivetrain',
                array_column(DrivetrainType::cases(), 'value')
            )->nullable();

            $table->string('color');

            $table->unsignedInteger('km_driven')->default(0);

            $table->text('description')->nullable();

            // Status
            $table->enum(
                'status',
                array_column(CarStatus::cases(), 'value')
            )->default(CarStatus::DRAFT->value);

            // Flags
            $table->boolean('is_special_offer')->default(false);

            $table->boolean('is_free_delivery')->default(false);

            // Rating
            $table->unsignedInteger('rating_count')->default(0);
            
            $table->decimal('rating_avg', 3, 2)->default(0);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['brand_id', 'car_model_id']);

            $table->index(['status']);

            $table->index(['owner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
