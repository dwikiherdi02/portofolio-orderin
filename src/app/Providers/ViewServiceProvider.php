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
                'order' => (object) [
                    'wildcard' => app('request')->routeIs('order.*'),
                    'index' => app('request')->routeIs('order.index'),
                    'create' => app('request')->routeIs('order.create'),
                ],
                'product' => (object) [
                    'wildcard' => app('request')->routeIs('product.*'),
                    'index' => app('request')->routeIs('product.index'),
                    'create' => app('request')->routeIs('product.create'),
                    'edit' => app('request')->routeIs('product.edit'),
                ],
                'customer' => (object) [
                    'wildcard' => app('request')->routeIs('customer.*'),
                    'index' => app('request')->routeIs('customer.index'),
                    'create' => app('request')->routeIs('customer.create'),
                    'edit' => app('request')->routeIs('customer.edit'),
                ],
            ];

            $view->with('isMenu', $isMenu);
        });
    }
}
