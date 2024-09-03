<?php

namespace App\Providers;

use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Facades\View::composer(['layouts.app', 'components.header'], function (View $view) {
            $routeArray = app('request')->route()->getAction();
            $controllerAction = $routeArray['controller'];
            list($controller, $action) = explode('@', $controllerAction);
            $instance = new $controller();
            $view->with('page', $instance::PAGE ?? '');
        });

        Facades\View::composer(['layouts.app', 'components.sidebar'], function (View $view) {
            $isMenu = (object) [
                'home' => app('request')->routeIs('home'),
                'order' => app('request')->routeIs('order.*'),
                'product' => app('request')->routeIs('product.*'),
                'customer' => app('request')->routeIs('customer.*'),
            ];

            $view->with('isMenu', $isMenu);
        });
    }
}
