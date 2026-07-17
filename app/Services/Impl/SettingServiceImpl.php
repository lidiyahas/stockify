<?php

namespace App\Services\Impl;

use App\Services\SettingService;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;

class SettingServiceImpl implements SettingService
{
    private SettingRepository $repo;

    public function __construct(SettingRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAppName(): string
    {
        return Cache::rememberForever('setting.app_name', function () {
            return $this->repo->get('app_name', 'Flowbite');
        });
    }

    public function getAppLogo(): string
    {
        return Cache::rememberForever('setting.app_logo', function () {
            return $this->repo->get('app_logo', 'static/images/logo.svg');
        });
    }

    public function updateAppIdentity(string $appName, ?string $logoPath = null): void
    {
        $this->repo->set('app_name', $appName);
        Cache::forget('setting.app_name');

        if ($logoPath) {
            $this->repo->set('app_logo', $logoPath);
            Cache::forget('setting.app_logo');
        }
    }
}
