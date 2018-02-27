<?php

namespace Wcr\Ican;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Wcr\Owner\Owner;
use Wcr\Ican\Permisison;
use Auth;

class IcanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //echo '<pre>user: '.print_r(Auth::user(), true).'</pre>';
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'], 'migrations');

        Blade::if('ican', function ($action, $entity) {
            return Permission::userHasPermission($action, $entity, Auth::user()->id);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
