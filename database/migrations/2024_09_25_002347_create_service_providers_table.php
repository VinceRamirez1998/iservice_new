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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            // Foreign key with cascading delete and update
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade')   // Cascade deletes
                  ->onUpdate('cascade')   // Cascade updates
                  ->nullable();           // Allow nulls on create if necessary

            $table->string('name');
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('active');
            $table->string('email')->unique();
            $table->string('complete_address')->nullable();
            $table->string('role')->nullable();
            $table->string('service')->nullable();
            $table->string('permission')->nullable();
            $table->string('primary_id')->nullable();
            $table->string('secondary_id')->nullable();
            $table->string('certification')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_providers');
    }
};
