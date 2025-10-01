<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SettingsService;

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
            'appearance' => $allSettings->where('section', 'appearance'),
            'general' => $allSettings->where('section', 'general'),
            'contact' => $allSettings->where('section', 'contact'),
            'social' => $allSettings->where('section', 'social'),
            'custom_code' => $allSettings->where('section', 'custom_code'),
        ];
        
        return view('admin.settings', compact('settings'));
    }
    
    /**
     * Serve dynamic CSS based on settings
     *
     * @return \Illuminate\Http\Response
     */
    public function dynamicCss()
    {
        // Get all appearance settings
        $settings = Setting::where('section', 'appearance')->get()->keyBy('key');
        
        // Helper function to safely output setting values
        $settingValue = function ($key, $default = '') use ($settings) {
            return isset($settings[$key]) ? $settings[$key]->value : $default;
        };
        
        // Helper function to convert HEX to RGBA
        $hexToRgba = function ($hex, $alpha = 1) {
            $hex = str_replace('#', '', $hex);
            
            if (strlen($hex) == 3) {
                $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
                $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
                $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            
            return "rgba($r, $g, $b, $alpha)";
        };
        
        // Generate CSS content
        $css = "/* Dynamic Styles Based on Settings */\n\n";
        
        // H1 Styles
        $css .= "h1 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h1_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h1_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h1_font_size_mobile', '24') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h1:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h1_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H1 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h1 {\n";
        $css .= "        font-size: " . $settingValue('h1_font_size_tablet', '28') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h1 {\n";
        $css .= "        font-size: " . $settingValue('h1_font_size_desktop', '32') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // H2 Styles
        $css .= "h2 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h2_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h2_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h2_font_size_mobile', '20') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h2:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h2_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H2 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h2 {\n";
        $css .= "        font-size: " . $settingValue('h2_font_size_tablet', '24') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h2 {\n";
        $css .= "        font-size: " . $settingValue('h2_font_size_desktop', '28') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // H3 Styles
        $css .= "h3 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h3_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h3_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h3_font_size_mobile', '18') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h3:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h3_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H3 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h3 {\n";
        $css .= "        font-size: " . $settingValue('h3_font_size_tablet', '20') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h3 {\n";
        $css .= "        font-size: " . $settingValue('h3_font_size_desktop', '24') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // H4 Styles
        $css .= "h4 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h4_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h4_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h4_font_size_mobile', '16') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h4:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h4_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H4 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h4 {\n";
        $css .= "        font-size: " . $settingValue('h4_font_size_tablet', '18') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h4 {\n";
        $css .= "        font-size: " . $settingValue('h4_font_size_desktop', '20') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // H5 Styles
        $css .= "h5 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h5_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h5_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h5_font_size_mobile', '14') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h5:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h5_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H5 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h5 {\n";
        $css .= "        font-size: " . $settingValue('h5_font_size_tablet', '16') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h5 {\n";
        $css .= "        font-size: " . $settingValue('h5_font_size_desktop', '18') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // H6 Styles
        $css .= "h6 {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h6_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('h6_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('h6_font_size_mobile', '12') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "h6:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('h6_hover_color', '#ff5b2e'), 1) . ";\n";
        $css .= "}\n\n";
        
        // H6 Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    h6 {\n";
        $css .= "        font-size: " . $settingValue('h6_font_size_tablet', '14') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    h6 {\n";
        $css .= "        font-size: " . $settingValue('h6_font_size_desktop', '16') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // Paragraph Styles
        $css .= "p {\n";
        $css .= "    color: " . $hexToRgba($settingValue('p_color', '#333333'), 1) . ";\n";
        $css .= "    font-family: " . $settingValue('p_font_family', 'Arial, sans-serif') . ";\n";
        $css .= "    font-size: " . $settingValue('p_font_size_mobile', '12') . "px;\n";
        $css .= "}\n\n";
        
        $css .= "p:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('p_hover_color', '#333333'), 1) . ";\n";
        $css .= "}\n\n";
        
        // Paragraph Responsive Styles
        $css .= "@media (min-width: 768px) {\n";
        $css .= "    p {\n";
        $css .= "        font-size: " . $settingValue('p_font_size_tablet', '14') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        $css .= "@media (min-width: 992px) {\n";
        $css .= "    p {\n";
        $css .= "        font-size: " . $settingValue('p_font_size_desktop', '16') . "px;\n";
        $css .= "    }\n";
        $css .= "}\n\n";
        
        // Link Styles
        $css .= "a {\n";
        $css .= "    color: " . $hexToRgba($settingValue('link_color', '#0d6efd'), 1) . ";\n";
        $css .= "}\n\n";
        
        $css .= "a:hover {\n";
        $css .= "    color: " . $hexToRgba($settingValue('link_hover_color', '#0b5ed7'), 1) . ";\n";
        $css .= "}\n\n";
        
        // Custom CSS
        $css .= $settingValue('custom_css', '');
        
        return response($css)->header('Content-Type', 'text/css');
    }
    
    /**
     * Ensure default settings exist
     *
     * @return void
     */
    private function ensureDefaultSettings()
    {
        // Appearance settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'primary_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'secondary_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        // H1 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_font_size_desktop'],
            ['value' => '32', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_font_size_tablet'],
            ['value' => '28', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h1_font_size_mobile'],
            ['value' => '24', 'type' => 'number']
        );
        
        // H2 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_font_size_desktop'],
            ['value' => '28', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_font_size_tablet'],
            ['value' => '24', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h2_font_size_mobile'],
            ['value' => '20', 'type' => 'number']
        );
        
        // H3 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_font_size_desktop'],
            ['value' => '24', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_font_size_tablet'],
            ['value' => '20', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h3_font_size_mobile'],
            ['value' => '18', 'type' => 'number']
        );
        
        // H4 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_font_size_desktop'],
            ['value' => '20', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_font_size_tablet'],
            ['value' => '18', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h4_font_size_mobile'],
            ['value' => '16', 'type' => 'number']
        );
        
        // H5 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_font_size_desktop'],
            ['value' => '18', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_font_size_tablet'],
            ['value' => '16', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h5_font_size_mobile'],
            ['value' => '14', 'type' => 'number']
        );
        
        // H6 settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_hover_color'],
            ['value' => '#ff5b2e', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_font_size_desktop'],
            ['value' => '16', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_font_size_tablet'],
            ['value' => '14', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'h6_font_size_mobile'],
            ['value' => '12', 'type' => 'number']
        );
        
        // Paragraph settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_hover_color'],
            ['value' => '#333333', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_font_family'],
            ['value' => 'Arial, sans-serif', 'type' => 'text']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_font_size_desktop'],
            ['value' => '16', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_font_size_tablet'],
            ['value' => '14', 'type' => 'number']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'p_font_size_mobile'],
            ['value' => '12', 'type' => 'number']
        );
        
        // Link color settings
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'link_color'],
            ['value' => '#0d6efd', 'type' => 'color']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'link_hover_color'],
            ['value' => '#0b5ed7', 'type' => 'color']
        );
        
        // Custom CSS
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'custom_css'],
            ['value' => '', 'type' => 'code']
        );
        
        Setting::firstOrCreate(
            ['section' => 'appearance', 'key' => 'header_style'],
            ['value' => 'sticky', 'type' => 'text']
        );
        
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
    }
    
    /**
     * Update appearance settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAppearance(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'primary_color' => 'nullable|string|max:7', // HEX color
            'secondary_color' => 'nullable|string|max:7', // HEX color
            'h1_color' => 'nullable|string|max:7',
            'h1_hover_color' => 'nullable|string|max:7',
            'h1_font_family' => 'nullable|string|max:255',
            'h1_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h1_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h1_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'h2_color' => 'nullable|string|max:7',
            'h2_hover_color' => 'nullable|string|max:7',
            'h2_font_family' => 'nullable|string|max:255',
            'h2_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h2_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h2_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'h3_color' => 'nullable|string|max:7',
            'h3_hover_color' => 'nullable|string|max:7',
            'h3_font_family' => 'nullable|string|max:255',
            'h3_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h3_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h3_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'h4_color' => 'nullable|string|max:7',
            'h4_hover_color' => 'nullable|string|max:7',
            'h4_font_family' => 'nullable|string|max:255',
            'h4_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h4_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h4_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'h5_color' => 'nullable|string|max:7',
            'h5_hover_color' => 'nullable|string|max:7',
            'h5_font_family' => 'nullable|string|max:255',
            'h5_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h5_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h5_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'h6_color' => 'nullable|string|max:7',
            'h6_hover_color' => 'nullable|string|max:7',
            'h6_font_family' => 'nullable|string|max:255',
            'h6_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'h6_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'h6_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'p_color' => 'nullable|string|max:7',
            'p_hover_color' => 'nullable|string|max:7',
            'p_font_family' => 'nullable|string|max:255',
            'p_font_size_desktop' => 'nullable|integer|min:1|max:100',
            'p_font_size_tablet' => 'nullable|integer|min:1|max:100',
            'p_font_size_mobile' => 'nullable|integer|min:1|max:100',
            'link_color' => 'nullable|string|max:7',
            'link_hover_color' => 'nullable|string|max:7',
            'custom_css' => 'nullable|string',
            'header_style' => 'nullable|string|max:255',
        ]);
        
        // Save settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                // Determine the type based on the key
                $type = 'text';
                if (strpos($key, 'color') !== false) {
                    $type = 'color';
                } elseif (strpos($key, 'size') !== false) {
                    $type = 'number';
                } elseif (strpos($key, 'css') !== false) {
                    $type = 'code';
                }
                
                Setting::set('appearance', $key, $value, $type);
            }
        }
        
        return redirect()->back()->with('success', 'Appearance settings updated successfully.');
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
            if ($value !== null && !in_array($key, ['logo', 'favicon'])) {
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
                    'type' => $setting['type'] ?? 'text'
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Settings imported successfully.');
    }
}