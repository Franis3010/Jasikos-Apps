<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrapFive(); // atau useBootstrapFour() kalau BS4
         View::composer('partials.site_header', function($view){
        $view->with('headerCategories', Category::orderBy('name')->take(6)->get());
    });
    }
}
