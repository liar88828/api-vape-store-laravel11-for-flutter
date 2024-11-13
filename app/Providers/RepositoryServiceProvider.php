<?php

namespace App\Providers;

use App\Interfaces\BankRepositoryInterface;
use App\Interfaces\CheckoutRepositoryInterface;
use App\Interfaces\DeliveryRepositoryInterface;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\TrolleyRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\BankRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\DeliveryRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TrolleyRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(DeliveryRepositoryInterface::class, DeliveryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
