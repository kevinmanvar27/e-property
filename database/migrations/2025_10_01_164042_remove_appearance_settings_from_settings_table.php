<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove all appearance settings from the settings table
        DB::table('settings')->where('section', 'appearance')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot restore the deleted settings as we don't have their values
        // In a real scenario, you might want to create a backup before running this migration
    }
};