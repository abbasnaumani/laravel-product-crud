<?php

namespace App\Providers;

use App\Contracts\ProductContract;
use App\Http\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Car services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductContract::class, fn () => new ProductService());
    }
}
