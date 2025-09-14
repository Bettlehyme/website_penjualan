<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\Settings;

if (! function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        // cache all settings for better performance
        $settings = Cache::rememberForever('settings', function () {
            return Settings::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}
