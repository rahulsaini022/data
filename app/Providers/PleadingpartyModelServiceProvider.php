<?php

namespace App\Providers;

use App\Pleadingparty;
use App\Observers\PleadingPartyObserver;
use Illuminate\Support\ServiceProvider;

class PleadingpartyModelServiceProvider extends ServiceProvider
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
        Pleadingparty::observe(PleadingPartyObserver::class);
    }
}
