<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Appearance settings
        Setting::updateOrCreate(
            ['section' => 'appearance', 'key' => 'primary_color'],
            ['value' => '#333333', 'type' => 'color']
        );

        Setting::updateOrCreate(
            ['section' => 'appearance', 'key' => 'secondary_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );

        Setting::updateOrCreate(
            ['section' => 'appearance', 'key' => 'header_style'],
            ['value' => 'sticky', 'type' => 'text']
        );

        // General settings
        Setting::updateOrCreate(
            ['section' => 'general', 'key' => 'website_title'],
            ['value' => 'E-Property', 'type' => 'text']
        );

        Setting::updateOrCreate(
            ['section' => 'general', 'key' => 'tagline'],
            ['value' => 'Find Your property destiny', 'type' => 'text']
        );

        // Contact settings (empty by default)
        Setting::updateOrCreate(
            ['section' => 'contact', 'key' => 'phone_number'],
            ['value' => '', 'type' => 'text']
        );

        Setting::updateOrCreate(
            ['section' => 'contact', 'key' => 'email_address'],
            ['value' => '', 'type' => 'email']
        );

        Setting::updateOrCreate(
            ['section' => 'contact', 'key' => 'physical_address'],
            ['value' => '', 'type' => 'text']
        );

        // Social media settings (empty by default)
        Setting::updateOrCreate(
            ['section' => 'social', 'key' => 'facebook_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::updateOrCreate(
            ['section' => 'social', 'key' => 'twitter_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::updateOrCreate(
            ['section' => 'social', 'key' => 'instagram_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::updateOrCreate(
            ['section' => 'social', 'key' => 'linkedin_url'],
            ['value' => '', 'type' => 'url']
        );

        // Custom code settings (empty by default)
        Setting::updateOrCreate(
            ['section' => 'custom_code', 'key' => 'header_code'],
            ['value' => '', 'type' => 'code']
        );

        Setting::updateOrCreate(
            ['section' => 'custom_code', 'key' => 'footer_code'],
            ['value' => '', 'type' => 'code']
        );
    }
}
