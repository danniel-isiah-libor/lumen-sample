<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helper\Auth;
use App\Helper\Contracts\AuthInterface;

use App\Services\Contracts\UserServiceInterface;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthInterface::class, Auth::class);

        $this->app->bind(UserServiceInterface::class, UserService::class);
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
