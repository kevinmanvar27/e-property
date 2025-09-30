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
        Schema::create('district', function (Blueprint $table) {
            $table->id('districtid');
            $table->string('district_title');
            $table->unsignedBigInteger('state_id');
            $table->text('district_description')->nullable();
            $table->enum('district_status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('state_id')->references('state_id')->on('state')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('district');
    }
};