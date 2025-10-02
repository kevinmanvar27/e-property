<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('setting')) {
    /**
     * Get a setting value by section and key
     *
     * @param string $section
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($section, $key, $default = null)
    {
        return \App\Models\Setting::get($section, $key, $default);
    }
}

if (! function_exists('setting_set')) {
    /**
     * Set a setting value by section and key
     *
     * @param string $section
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return void
     */
    function setting_set($section, $key, $value, $type = 'text')
    {
        \App\Models\Setting::set($section, $key, $value, $type);
    }
}

if (! function_exists('hasPermission')) {
    /**
     * Check if the authenticated user has a specific permission
     *
     * @param string $module
     * @param string $action
     * @return bool
     */
    function hasPermission($module, $action)
    {
        // If user is not authenticated, return false
        if (! auth()->check()) {
            return false;
        }

        $user = auth()->user();

        // Super admins have all permissions
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Check if user has the specific permission
        return $user->hasPermission($module, $action);
    }
}

if (! function_exists('safe_asset')) {
    /**
     * Generate a secure asset path for the application.
     *
     * @param  string  $path
     * @param  string|null  $fallback
     * @return string
     */
    function safe_asset($path, $fallback = null)
    {
        // For storage paths, we need to check the actual file path
        if (strpos($path, 'storage/') === 0) {
            // Convert storage path to actual file path
            $filePath = str_replace('storage/', '', $path);
            if (Storage::disk('public')->exists($filePath)) {
                return asset($path);
            }
        } else {
            // Check if the file exists using the default path
            if (Storage::exists($path)) {
                return asset($path);
            }
        }

        // Return fallback if provided
        if ($fallback) {
            return asset($fallback);
        }

        // Return default asset path
        return asset($path);
    }
}

if (! function_exists('hex_to_rgba')) {
    /**
     * Convert HEX color to RGBA
     *
     * @param string $hex
     * @param float $alpha
     * @return string
     */
    function hex_to_rgba($hex, $alpha = 1)
    {
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
    }
}

if (! function_exists('get_rgba_setting')) {
    /**
     * Get a color setting and convert it to RGBA format
     *
     * @param string $section
     * @param string $key
     * @param float $alpha
     * @param string $default
     * @return string
     */
    function get_rgba_setting($section, $key, $alpha = 1, $default = '#333333')
    {
        $hex = setting($section, $key, $default);

        return hex_to_rgba($hex, $alpha);
    }
}
