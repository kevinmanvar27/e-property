<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the modules and actions
        $modules = [
            'land-jamin' => 'Land / Jamin',
            'plot' => 'Plot',
            'shad' => 'Shad',
            'shop' => 'Shop',
            'house' => 'House',
            'amenities' => 'Amenities',
            'land-types' => 'Land Types',
            'countries' => 'Countries',
            'states' => 'States',
            'districts' => 'Districts',
            'cities' => 'Cities/Talukas',
            'settings' => 'Settings',
            'users-management' => 'Management Users',
            'users-regular' => 'Regular Users',
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        // Create permissions for each module and action
        foreach ($modules as $moduleKey => $moduleLabel) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $moduleKey . '-' . $action,
                    'module' => $moduleKey,
                    'action' => $action,
                ]);
            }
        }
    }
}
