<?php

namespace App\Providers;

use App\Interfaces\CheckoutRepositoryInterface;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Checkout;
use App\Repositories\CheckoutRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TrolleyRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TrolleyRepositoryInterface::class, TrolleyRepository::class);
        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
        $this->app->bind(CheckoutRepositoryInterface::class, CheckoutRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
