<?php

namespace App\Repositories;

interface SettingRepository
{
    public function get(string $key, $default = null);
    public function set(string $key, $value): void;
}
