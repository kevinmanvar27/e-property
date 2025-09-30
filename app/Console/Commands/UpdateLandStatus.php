<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateLandStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'land-jamin:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all land records to have active status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updated = DB::table('land_jamin')->update(['status' => 'active']);
        $this->info("Updated {$updated} land records to active status.");
    }
}