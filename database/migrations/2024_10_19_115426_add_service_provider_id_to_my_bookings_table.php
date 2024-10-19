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
        Schema::table('my_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->nullable()->after('user_id');
            
            // Optional: Add a foreign key constraint if needed
            // $table->foreign('service_provider_id')->references('id')->on('service_providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_bookings', function (Blueprint $table) {
            $table->dropColumn('service_provider_id');
        });
    }
};
