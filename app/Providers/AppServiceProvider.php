<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\SettingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\StockTransactionService::class, \App\Services\Impl\StockTransactionServiceImpl::class);
        $this->app->bind(\App\Repositories\StockTransactionRepository::class, \App\Repositories\Impl\StockTransactionRepositoryImpl::class);

        $this->app->bind(\App\Services\DashboardService::class, \App\Services\Impl\DashboardServiceImpl::class);
        $this->app->bind(\App\Repositories\DashboardRepository::class, \App\Repositories\Impl\DashboardRepositoryImpl::class);

        $this->app->bind(\App\Services\CategoryService::class, \App\Services\Impl\CategoryServiceImpl::class);
        $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\Impl\CategoryRepositoryImpl::class);

        $this->app->bind(\App\Services\SupplierService::class, \App\Services\Impl\SupplierServiceImpl::class);
        $this->app->bind(\App\Repositories\SupplierRepository::class, \App\Repositories\Impl\SupplierRepositoryImpl::class);

        $this->app->bind(\App\Services\ProductAttributeService::class, \App\Services\Impl\ProductAttributeServiceImpl::class);
        $this->app->bind(\App\Repositories\ProductAttributeRepository::class, \App\Repositories\Impl\ProductAttributeRepositoryImpl::class);

        $this->app->bind(\App\Services\UserService::class, \App\Services\Impl\UserServiceImpl::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\Impl\UserRepositoryImpl::class);

        $this->app->bind(\App\Services\ProductService::class, \App\Services\Impl\ProductServiceImpl::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\Impl\ProductRepositoryImpl::class);

        $this->app->bind(\App\Services\StockOpnameService::class, \App\Services\Impl\StockOpnameServiceImpl::class);

        $this->app->bind(\App\Services\ReportService::class, \App\Services\Impl\ReportServiceImpl::class);
        $this->app->bind(\App\Repositories\ReportRepository::class, \App\Repositories\Impl\ReportRepositoryImpl::class);

        $this->app->bind(\App\Services\SettingService::class, \App\Services\Impl\SettingServiceImpl::class);
        $this->app->bind(\App\Repositories\SettingRepository::class, \App\Repositories\Impl\SettingRepositoryImpl::class);

        $this->app->bind(\App\Services\ActivityLogService::class, \App\Services\Impl\ActivityLogServiceImpl::class);
        $this->app->bind(\App\Repositories\ActivityLogRepository::class, \App\Repositories\Impl\ActivityLogRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SettingService $settingService): void
    {
        View::composer('*', function ($view) use ($settingService) {
            $app_name = $settingService->getAppName();
            $app_logo = $settingService->getAppLogo();

            $view->with(compact('app_name', 'app_logo'));
        });
    }
}
