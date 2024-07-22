<?php

namespace App\Providers;

use App\Interfaces\FruitRepositoryInterface;
use App\Repositories\FruitRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FruitRepositoryInterface::class, FruitRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
