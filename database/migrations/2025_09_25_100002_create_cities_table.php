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
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('districtid');
            $table->unsignedBigInteger('state_id');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('districtid')->references('districtid')->on('district')->onDelete('cascade');
            $table->foreign('state_id')->references('state_id')->on('state')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};