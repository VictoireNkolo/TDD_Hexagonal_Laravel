<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Domain\Auth\AuthRepository;
use Module\Domain\Auth\PasswordProvider;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;
use Module\Infrastructure\Auth\PasswordProviderLaravel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PasswordProvider::class, PasswordProviderLaravel::class);
        $this->app->bind(AuthRepository::class, AuthRepositoryEloquent::class);
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
