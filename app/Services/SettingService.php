<?php

namespace App\Services;

interface SettingService
{
    public function getAppName(): string;
    public function getAppLogo(): string;
    public function updateAppIdentity(string $appName, ?string $logoPath = null): void;
}
