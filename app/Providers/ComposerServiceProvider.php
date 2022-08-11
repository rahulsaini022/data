<?php

namespace App\Providers;

use DB;
use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.app', function($view) {
            $settings = DB::table('settings')->get()->all();
            $view->with('settings', $settings);
        });
    }

    public function register()
    {
        //
    }

}
