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
        // Check the database driver to use appropriate syntax
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            // MySQL syntax
            DB::statement("ALTER TABLE land_jamin MODIFY COLUMN status ENUM('active', 'inactive', 'urgent', 'under_offer', 'reserved', 'sold', 'cancelled', 'coming_soon', 'price_reduced') DEFAULT 'active'");
        } else {
            // For SQLite and other databases, we need a different approach
            // SQLite doesn't support MODIFY COLUMN directly
            // We'll skip this migration for SQLite as it's mainly for testing
            // In production with MySQL, this will work correctly
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check the database driver to use appropriate syntax
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            // Revert to the previous enum values for MySQL
            DB::statement("ALTER TABLE land_jamin MODIFY COLUMN status ENUM('active', 'inactive') DEFAULT 'active'");
        } else {
            // For SQLite and other databases, we need a different approach
            // SQLite doesn't support MODIFY COLUMN directly
            // We'll skip this migration for SQLite as it's mainly for testing
        }
    }
};