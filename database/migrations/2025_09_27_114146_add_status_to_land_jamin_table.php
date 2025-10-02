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
        Schema::table('land_jamin', function (Blueprint $table) {
            $table->enum('status', [
                'active',
                'inactive',
                'urgent',
                'under_offer',
                'reserved',
                'sold',
                'cancelled',
                'coming_soon',
                'price_reduced',
            ])->default('active')->after('document_8a');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('land_jamin', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
