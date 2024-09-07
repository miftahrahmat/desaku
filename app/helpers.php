<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value)
    {
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
