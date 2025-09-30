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
        // Log that we're starting the migration
        \Log::info('Starting refactor_land_jamin_to_properties_v2 migration');
        
        // Check if the properties table already exists
        if (!Schema::hasTable('properties')) {
            \Log::info('Properties table does not exist, proceeding with migration');
            
            // Add JSON columns and property_type to land_jamin table
            if (Schema::hasTable('land_jamin')) {
                \Log::info('Land_jamin table exists, adding columns');
                
                Schema::table('land_jamin', function (Blueprint $table) {
                    // Add columns without indexes to avoid conflicts
                    if (!Schema::hasColumn('land_jamin', 'amenities')) {
                        $table->json('amenities')->nullable();
                    }
                    if (!Schema::hasColumn('land_jamin', 'land_types')) {
                        $table->json('land_types')->nullable();
                    }
                    if (!Schema::hasColumn('land_jamin', 'photos')) {
                        $table->json('photos')->nullable();
                    }
                    if (!Schema::hasColumn('land_jamin', 'property_type')) {
                        $table->string('property_type')->default('land_jamin');
                    }
                });
                
                // Migrate data from related tables to JSON columns
                \Log::info('Migrating data to JSON columns');
                $this->migrateRelatedDataToJson();
                
                // Rename the table to properties
                \Log::info('Renaming land_jamin to properties');
                Schema::rename('land_jamin', 'properties');
            } else {
                \Log::info('Land_jamin table does not exist');
            }
        } else {
            \Log::info('Properties table already exists, skipping migration');
        }
        
        // Drop the related tables as they're no longer needed
        \Log::info('Dropping related tables');
        Schema::dropIfExists('land_amenities');
        Schema::dropIfExists('land_land_types');
        Schema::dropIfExists('land_photos');
        
        \Log::info('Completed refactor_land_jamin_to_properties_v2 migration');
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a simplified reverse migration and may not restore all data perfectly
        if (Schema::hasTable('properties')) {
            Schema::rename('properties', 'land_jamin');
        }
    }
    
    /**
     * Migrate data from related tables to JSON columns
     */
    private function migrateRelatedDataToJson()
    {
        try {
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
        } catch (\Exception $e) {
            // Log the error but continue with the migration
            \Log::error('Error migrating data to JSON: ' . $e->getMessage());
        }
    }
};