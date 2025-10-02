<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('land_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id');
            $table->unsignedBigInteger('amenity_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('land_id')->references('id')->on('land_jamin')->onDelete('cascade');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');

            // Prevent duplicate entries
            $table->unique(['land_id', 'amenity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_amenities');
    }
};
