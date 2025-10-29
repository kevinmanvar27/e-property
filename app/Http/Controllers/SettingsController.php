<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display the settings page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ensure default settings exist
        $this->ensureDefaultSettings();

        // Get all settings grouped by section using the service
        $allSettings = Setting::all();
        $settings = [
            'general' => $allSettings->where('section', 'general'),
            'contact' => $allSettings->where('section', 'contact'),
            'social' => $allSettings->where('section', 'social'),
            'custom_code' => $allSettings->where('section', 'custom_code'),
            'app_link' => $allSettings->where('section', 'app_link'),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Ensure default settings exist
     *
     * @return void
     */
    private function ensureDefaultSettings()
    {
        // General settings
        Setting::firstOrCreate(
            ['section' => 'general', 'key' => 'website_title'],
            ['value' => 'E-Property', 'type' => 'text']
        );

        Setting::firstOrCreate(
            ['section' => 'general', 'key' => 'tagline'],
            ['value' => 'Find Your property destiny', 'type' => 'text']
        );

        // Auto logout timeout setting (in minutes)
        Setting::firstOrCreate(
            ['section' => 'general', 'key' => 'auto_logout_timeout'],
            ['value' => '30', 'type' => 'number']
        );

        // Contact settings (empty by default)
        Setting::firstOrCreate(
            ['section' => 'contact', 'key' => 'phone_number'],
            ['value' => '', 'type' => 'text']
        );

        Setting::firstOrCreate(
            ['section' => 'contact', 'key' => 'email_address'],
            ['value' => '', 'type' => 'text']
        );

        Setting::firstOrCreate(
            ['section' => 'contact', 'key' => 'physical_address'],
            ['value' => '', 'type' => 'text']
        );

        // Social settings (empty by default)
        Setting::firstOrCreate(
            ['section' => 'social', 'key' => 'facebook_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::firstOrCreate(
            ['section' => 'social', 'key' => 'twitter_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::firstOrCreate(
            ['section' => 'social', 'key' => 'instagram_url'],
            ['value' => '', 'type' => 'url']
        );

        Setting::firstOrCreate(
            ['section' => 'social', 'key' => 'linkedin_url'],
            ['value' => '', 'type' => 'url']
        );

        // Custom code settings (empty by default)
        Setting::firstOrCreate(
            ['section' => 'custom_code', 'key' => 'header_code'],
            ['value' => '', 'type' => 'code']
        );

        Setting::firstOrCreate(
            ['section' => 'custom_code', 'key' => 'footer_code'],
            ['value' => '', 'type' => 'code']
        );

        // App link settings (empty by default)
        Setting::firstOrCreate(
            ['section' => 'app_link', 'key' => 'app_store_link'],
            ['value' => '', 'type' => 'url']
        );

        Setting::firstOrCreate(
            ['section' => 'app_link', 'key' => 'google_play_link'],
            ['value' => '', 'type' => 'url']
        );
    }

    /**
     * Update general settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGeneral(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'website_title' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'auto_logout_timeout' => 'nullable|integer|min:1|max:1440', // 1 minute to 24 hours
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,ico|max:2048',
        ]);

        // Save text settings
        foreach ($validated as $key => $value) {
            if ($value !== null && ! in_array($key, ['logo', 'favicon'])) {
                Setting::set('general', $key, $value);
            }
        }

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            Setting::set('general', 'logo', $logoPath, 'file');
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            Setting::set('general', 'favicon', $faviconPath, 'file');
        }

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }

    /**
     * Update contact settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateContact(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'physical_address' => 'nullable|string|max:500',
        ]);

        // Save settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::set('contact', $key, $value);
            }
        }

        return redirect()->back()->with('success', 'Contact settings updated successfully.');
    }

    /**
     * Update social media settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSocial(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        // Save settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::set('social', $key, $value, 'url');
            }
        }

        return redirect()->back()->with('success', 'Social media settings updated successfully.');
    }

    /**
     * Update custom code settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCustomCode(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'header_code' => 'nullable|string',
            'footer_code' => 'nullable|string',
        ]);

        // Save settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::set('custom_code', $key, $value, 'code');
            }
        }

        return redirect()->back()->with('success', 'Custom code settings updated successfully.');
    }

    /**
     * Update app link settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAppLink(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'app_store_link' => 'nullable|url|max:255',
            'google_play_link' => 'nullable|url|max:255',
        ]);

        // Save settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::set('app_link', $key, $value, 'url');
            }
        }

        return redirect()->back()->with('success', 'App link settings updated successfully.');
    }

    /**
     * Export settings as JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $settings = Setting::all();
        $filename = 'settings_export_' . date('Y-m-d_H-i-s') . '.json';

        return response()->json($settings)->header('Content-Disposition', 'attachment; filename=' . $filename);
    }

    /**
     * Import settings from JSON
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json',
        ]);

        $file = $request->file('settings_file');
        $content = file_get_contents($file->getPathname());
        $settings = json_decode($content, true);

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['section' => $setting['section'], 'key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'] ?? 'text',
                ]
            );
        }

        return redirect()->back()->with('success', 'Settings imported successfully.');
    }
}
