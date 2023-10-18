<?php

namespace App\Providers;

use App\Http\Repositories\BeerRepository;
use App\Http\Repositories\Interfaces\BeerRepositoryInterface;
use App\Http\Services\BeerService;
use App\Http\Services\Interfaces\BeerServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BeerServiceInterface::class, BeerService::class);
        $this->app->bind(BeerRepositoryInterface::class, BeerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
