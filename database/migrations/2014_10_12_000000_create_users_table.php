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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('pending');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('complete_address')->nullable();
            $table->string('role')->nullable();
            $table->string('service')->nullable();
            $table->string('permission')->nullable();
            $table->string('primary_id')->nullable();
            $table->string('secondary_id')->nullable();
            $table->string('certification')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->string('subscription_duration')->nullable();
            $table->unsignedDecimal('rating', 3, 2)->nullable(); // Add the rating column
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
