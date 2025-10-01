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
        // We'll add the auto logout timeout setting through the seeder instead of a direct database insert
        // This approach is more consistent with how other settings are handled in the application
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the auto logout timeout setting if needed
        DB::table('settings')->where('section', 'general')->where('key', 'auto_logout_timeout')->delete();
    }
};