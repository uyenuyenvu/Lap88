<?php

namespace App\Providers;

use App\Http\Views\ListTrademarkComposer;
use Illuminate\Support\ServiceProvider;

class TrademarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'backend.products.index',
            'backend.products.create',
            'backend.products.edit',
            'backend.categories.create',
            'backend.categories.edit',
        ], ListTrademarkComposer::class);
    }
}
