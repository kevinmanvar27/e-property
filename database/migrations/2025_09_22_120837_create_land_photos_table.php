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
        Schema::create('land_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id');
            $table->string('photo_path');
            $table->integer('position')->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('land_id')->references('id')->on('land_jamin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_photos');
    }
};
