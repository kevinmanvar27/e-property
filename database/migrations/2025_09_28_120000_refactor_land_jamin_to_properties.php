<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add JSON columns and property_type to land_jamin table
        Schema::table('land_jamin', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('land_jamin', 'amenities')) {
                $table->json('amenities')->nullable()->after('document_8a');
            }
            if (!Schema::hasColumn('land_jamin', 'land_types')) {
                $table->json('land_types')->nullable()->after('amenities');
            }
            if (!Schema::hasColumn('land_jamin', 'photos')) {
                $table->json('photos')->nullable()->after('land_types');
            }
            if (!Schema::hasColumn('land_jamin', 'property_type')) {
                $table->string('property_type')->default('land_jamin')->after('status');
            }
            
            // Note: Skip adding indexes as they might already exist or be auto-created
        });
        
        // Step 2: Migrate data from related tables to JSON columns
        $this->migrateRelatedDataToJson();
        
        // Step 3: Rename the table to properties
        Schema::rename('land_jamin', 'properties');
        
        // Step 4: Drop the related tables as they're no longer needed
        Schema::dropIfExists('land_amenities');
        Schema::dropIfExists('land_land_types');
        Schema::dropIfExists('land_photos');
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the related tables
        // Note: This is a simplified reverse migration and may not restore all data perfectly
        Schema::create('land_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id');
            $table->string('photo_path');
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->foreign('land_id')->references('id')->on('properties')->onDelete('cascade');
        });
        
        Schema::create('land_land_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id');
            $table->unsignedBigInteger('land_type_id');
            $table->timestamps();
            $table->foreign('land_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('land_type_id')->references('id')->on('land_types')->onDelete('cascade');
            $table->unique(['land_id', 'land_type_id']);
        });
        
        Schema::create('land_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id');
            $table->unsignedBigInteger('amenity_id');
            $table->timestamps();
            $table->foreign('land_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');
            $table->unique(['land_id', 'amenity_id']);
        });
        
        // Rename the table back to land_jamin
        Schema::rename('properties', 'land_jamin');
        
        // Remove the JSON columns and property_type
        Schema::table('land_jamin', function (Blueprint $table) {
            $table->dropColumn(['amenities', 'land_types', 'photos', 'property_type']);
        });
    }
    
    /**
     * Migrate data from related tables to JSON columns
     */
    private function migrateRelatedDataToJson()
    {
        // Migrate amenities data
        $lands = DB::table('land_jamin')->get();
        foreach ($lands as $land) {
            // Get amenities for this land
            $amenityIds = DB::table('land_amenities')
                ->where('land_id', $land->id)
                ->pluck('amenity_id')
                ->toArray();
            
            // Update the land record with amenities JSON
            DB::table('land_jamin')
                ->where('id', $land->id)
                ->update(['amenities' => json_encode($amenityIds)]);
            
            // Get land types for this land
            $landTypeIds = DB::table('land_land_types')
                ->where('land_id', $land->id)
                ->pluck('land_type_id')
                ->toArray();
            
            // Update the land record with land types JSON
            DB::table('land_jamin')
                ->where('id', $land->id)
                ->update(['land_types' => json_encode($landTypeIds)]);
            
            // Get photos for this land
            $photos = DB::table('land_photos')
                ->where('land_id', $land->id)
                ->select('photo_path', 'position')
                ->get()
                ->toArray();
            
            // Update the land record with photos JSON
            DB::table('land_jamin')
                ->where('id', $land->id)
                ->update(['photos' => json_encode($photos)]);
        }
    }
};