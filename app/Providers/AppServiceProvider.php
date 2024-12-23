<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('hasrole', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });
    
        Blade::directive('endhasrole', function () {
            return "<?php endif; ?>";
        });
    
        Blade::directive('impersonate', function () {
            return "<?php if(session()->has('impersonate')): ?>";
        });
    
        Blade::directive('endimpersonate', function () {
            return "<?php endif; ?>";
        });
        //
        Paginator::useBootstrap();
    }
}
