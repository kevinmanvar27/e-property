<?php

namespace App\Models;

use App\Services\SettingsService;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when settings are saved
        static::saved(function ($setting) {
            $settingsService = new SettingsService();
            $settingsService->clearCache();
        });

        // Clear cache when settings are deleted
        static::deleted(function ($setting) {
            $settingsService = new SettingsService();
            $settingsService->clearCache();
        });
    }

    /**
     * Get a setting value by section and key
     *
     * @param string $section
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($section, $key, $default = null)
    {
        $setting = self::where('section', $section)->where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by section and key
     *
     * @param string $section
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return void
     */
    public static function set($section, $key, $value, $type = 'text')
    {
        self::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}
