<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom('database/migrations/factory');
        $this->loadMigrationsFrom('database/migrations/egerep');

        Validator::extend('allow_tags', function ($attribute, $value, $allowed_tags, $validator) {
           preg_match_all('#</?([\w]+)>#', $value, $m);
           $tags = array_unique($m[1]);
           foreach($tags as $tag) {
               if (! in_array($tag, $allowed_tags)) {
                   return false;
               }
           }
           return true;
       });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
