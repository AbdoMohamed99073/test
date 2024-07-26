<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Validator::extend('filter', function ($attribute, $value ,$pars) {
            if(in_array(strtolower($value) , $pars)) {return false;}return true;
        }
    ,'The world in not');


    Paginator::useBootstrapFive();
}
}
