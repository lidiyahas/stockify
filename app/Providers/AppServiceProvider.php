<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(\App\Services\StockTransactionService::class, \App\Services\Impl\StockTransactionServiceImpl::class);
        // $this->app->bind(\App\Repositories\StockTransactionRepository::class, \App\Repositories\Impl\StockTransactionRepositoryImpl::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        $app_name = session('app_name', 'Flowbite');
        $app_logo = session('app_logo', 'static/images/logo.svg');

        $view->with(compact('app_name', 'app_logo'));
    });
    }
}
