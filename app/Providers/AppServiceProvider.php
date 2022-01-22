<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\allClass\helpers\VueCliSession;
use App;
use App\MyAppConstants;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton(MyAppConstants::MY_SESSION, function()
        {
            return new VueCliSession();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
