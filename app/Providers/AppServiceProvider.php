<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
            if (Auth::check()) {
                $profile = UserProfile::where('user_id', Auth::id())->first();
                $view->with('profile', $profile);
            }
        });
    }
}
