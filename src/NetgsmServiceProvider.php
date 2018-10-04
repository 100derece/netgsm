<?php

namespace Yuzderece\Netgsm;

use Illuminate\Support\ServiceProvider;

class NetgsmServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/netgsm.php'=>config_path('netgsm.php')
        ],'config'); //php artisan vendor:publish --tag='config'
    }

    public function register(){
		$this->mergeConfigFrom(__DIR__.'/../config/netgsm.php','netgsm');
		$this->app->singleton('netgsm',function ($app){
            $config=$app->make('config');
            return new Netgsm($config);
        });
    }

    public function provides(){
        return ['netgsm'];
    }
}
