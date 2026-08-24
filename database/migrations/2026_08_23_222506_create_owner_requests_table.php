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
        Schema::create('owner_requests', function (Blueprint $table) {
            $table->id();

            // The renter who is requesting to become an owner
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Request status
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            // Snapshot of applicant data at submission time
            $table->string('full_name');
            $table->string('phone');
            $table->string('national_id');

            // Optional applicant notes
            $table->text('notes')->nullable();

            // Admin review information
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('rejection_reason')->nullable();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_requests');
    }
};
