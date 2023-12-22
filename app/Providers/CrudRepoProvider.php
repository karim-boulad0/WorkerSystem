<?php

namespace App\Providers;

use App\Interfaces\CrudRepoInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ClientOrderRepository;
use App\Http\Controllers\Dashboard\order\client\ClientOrderController;
use App\Http\Controllers\WebSite\Order\OrderController;

class CrudRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(CrudRepoInterface::class, ClientOrderRepository::class);
        $this->app->when(OrderController::class)
            ->needs(CrudRepoInterface::class)
            ->give(function () {
                return new ClientOrderRepository();
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
