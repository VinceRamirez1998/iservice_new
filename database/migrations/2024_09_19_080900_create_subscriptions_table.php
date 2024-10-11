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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Customer name
            $table->string('email')->nullable(); // Customer email
            $table->string('address')->nullable(); // Customer address
            $table->string('phone')->nullable(); // Customer phone number
            $table->decimal('amount', 10, 2); // Amount to be billed
            $table->string('status')->default('pending'); // Status of the bill
            $table->string('reference_no')->unique(); // Reference number for the bill
            $table->string('bank')->nullable(); // banks
            $table->string('subscription_plan')->nullable();
            $table->string('subscription_duration')->nullable();
            $table->string('image')->nullable();
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
