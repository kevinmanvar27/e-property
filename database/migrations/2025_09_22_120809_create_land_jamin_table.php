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
        Schema::create('land_jamin', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name');
            $table->string('first_line');
            $table->string('second_line')->nullable();
            $table->string('village');
            $table->unsignedInteger('taluka_id')->nullable();
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('state_id');
            $table->string('pincode');
            $table->string('country')->default('India');
            $table->string('vavetar')->nullable();
            $table->string('any_issue')->nullable();
            $table->text('issue_description')->nullable();
            $table->string('electric_poll')->nullable();
            $table->integer('electric_poll_count')->nullable();
            $table->string('family_issue')->nullable();
            $table->text('family_issue_description')->nullable();
            $table->decimal('road_distance', 8, 2)->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('document_7_12')->nullable();
            $table->string('document_8a')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_jamin');
    }
};