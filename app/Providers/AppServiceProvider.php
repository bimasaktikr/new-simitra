<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $userDetails = null;

            if ($user) {
                if ($user->mitra) {
                    $userDetails = $user->mitra;
                } elseif ($user->employee) {
                    $userDetails = $user->employee;
                }
            }

            $view->with('authUser', $user)->with('userDetails', $userDetails);
        });
    }
}
