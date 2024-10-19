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
        Schema::create('customer_bookings', function (Blueprint $table) {
            $table->id();
            // Foreign key with cascading delete and update
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade')   // Cascade deletes
                  ->onUpdate('cascade')   // Cascade updates
                  ->nullable();           // Allow nulls on create if necessary

            // Add the service_provider_id
            $table->foreignId('service_provider_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');


            $table->string('name');
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('active');
            $table->string('email')->nullable();
            $table->string('complete_address')->nullable();
            $table->string('role')->nullable();
            $table->string('service')->nullable();
            $table->string('permission')->nullable();
            $table->string('primary_id')->nullable();
            $table->string('secondary_id')->nullable();
            $table->timestamp('reschedule')->nullable();
            $table->timestamp('schedule')->nullable();
            $table->string('certification')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->string('approval')->default('pending');
            $table->string('subscription_duration')->nullable();
            $table->unsignedDecimal('rating', 3, 2)->nullable(); // Rating column
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_bookings');
    }
};
