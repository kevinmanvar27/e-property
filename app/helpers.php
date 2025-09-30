<?php

if (!function_exists('setting')) {
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

if (!function_exists('setting_set')) {
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

if (!function_exists('safe_asset')) {
    /**
     * Safely get asset path, checking if file exists
     *
     * @param string $path
     * @param string $default
     * @return string
     */
    function safe_asset($path, $default = null)
    {
        // For storage files, check if they exist
        if (strpos($path, 'storage/') === 0) {
            $storagePath = str_replace('storage/', '', $path);
            if (file_exists(storage_path('app/public/' . $storagePath))) {
                return asset($path);
            }
        } else {
            // For regular assets, check if file exists
            $publicPath = public_path($path);
            if (file_exists($publicPath)) {
                return asset($path);
            }
        }
        
        // Return default if provided, otherwise return the original path
        return $default ? asset($default) : asset($path);
    }
}

if (!function_exists('hex_to_rgba')) {
    /**
     * Convert HEX color to RGBA
     *
     * @param string $hex
     * @param float $alpha
     * @return string
     */
    function hex_to_rgba($hex, $alpha = 1) {
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

if (!function_exists('get_rgba_setting')) {
    /**
     * Get a color setting and convert it to RGBA format
     *
     * @param string $section
     * @param string $key
     * @param float $alpha
     * @param string $default
     * @return string
     */
    function get_rgba_setting($section, $key, $alpha = 1, $default = '#333333') {
        $hex = setting($section, $key, $default);
        return hex_to_rgba($hex, $alpha);
    }
}