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
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('bhk')->nullable()->after('apartment_name');
            $table->string('is_apartment')->default('no')->after('bhk');
            $table->integer('apartment_floor')->nullable()->after('is_apartment');
            $table->string('is_tenament')->default('no')->after('apartment_floor');
            $table->integer('tenament_floors')->nullable()->after('is_tenament');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['bhk', 'is_apartment', 'apartment_floor', 'is_tenament', 'tenament_floors']);
        });
    }
};
