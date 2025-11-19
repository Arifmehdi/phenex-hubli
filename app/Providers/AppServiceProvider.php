<?php

namespace App\Providers;


use App\Models\Menu;
use App\Models\Page;
use App\Models\WebsiteParameter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            // if (session()->has('locale')) {
            //     app()->setLocale(session('locale'));
            // }

        View::composer('*', function ($view) {
            View::share('headerMenus', Menu::whereActive(true)->where('type','header_menu')->orderBy('drag_id')->latest()->get());
            View::share('footerMenus', Menu::whereActive(true)->where('type','footer_menu')->orderBy('drag_id')->latest()->get());
            View::share('ws',WebsiteParameter::first());
        });

        Paginator::useBootstrap();
    }
}
