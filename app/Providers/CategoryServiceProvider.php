<?php

namespace App\Providers;

use App\Http\Views\ListCategoryComposer;
use App\Http\Views\MenuCategoryComposer;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
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
            'frontend.includes.header',
            'frontend.includes.footer',
            ], MenuCategoryComposer::class);
        view()->composer([
            'backend.products.index',
            'backend.products.create',
            'backend.products.edit',
            'backend.categories.edit',
        ], ListCategoryComposer::class);
    }
}
