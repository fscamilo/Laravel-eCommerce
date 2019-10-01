<?php

namespace App\Providers;

use App\User;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
        $this->app->singleton(UserRepository::class, function($app){
            return new UserRepository();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
