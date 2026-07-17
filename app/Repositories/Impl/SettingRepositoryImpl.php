<?php

namespace App\Repositories\Impl;

use App\Repositories\SettingRepository;
use App\Models\Setting;

class SettingRepositoryImpl implements SettingRepository
{
    public function get(string $key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public function set(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
