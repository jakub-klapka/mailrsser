<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Providers\ImapConnection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

	    //Abort on non secure connections
        if( !App::runningInConsole() && $_SERVER[ 'HTTPS' ] !== 'on' ) abort( 401, 'Unsecure connection' );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton( ImapConnection::class );

    }
}
