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
    }
}
