<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(\Kreait\Firebase\Auth::class, function ($app) {
            $factory = (new Factory)
                ->withServiceAccount(config('services.firebase.credentials_file'));
            return $factory->createAuth();
        });

        $this->app->singleton('firebase.firestore', function ($app) {
            $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials_file'));
            return $factory->createFirestore()->database();
        });
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        //
    }
}
