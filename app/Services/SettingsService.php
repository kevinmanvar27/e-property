<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected $cacheKey = 'app_settings';
    protected $cacheDuration = 3600; // 1 hour

    /**
     * Get all settings with caching
     *
     * @return array
     */
    public function getAllSettings()
    {
        return Cache::remember($this->cacheKey, $this->cacheDuration, function () {
            return Setting::all()->groupBy('section')->toArray();
        });
    }

    /**
     * Get a specific setting value
     *
     * @param string $section
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getSetting($section, $key, $default = null)
    {
        $settings = $this->getAllSettings();

        if (isset($settings[$section])) {
            foreach ($settings[$section] as $setting) {
                if ($setting['key'] === $key) {
                    return $setting['value'];
                }
            }
        }

        return $default;
    }

    /**
     * Clear settings cache
     *
     * @return void
     */
    public function clearCache()
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Get all settings as key-value pairs for API response
     *
     * @return array
     */
    public function getSettingsForApi()
    {
        $settings = $this->getAllSettings();
        $result = [];

        foreach ($settings as $section => $sectionSettings) {
            foreach ($sectionSettings as $setting) {
                $result[$setting['key']] = $setting['value'];
            }
        }

        return $result;
    }
}
