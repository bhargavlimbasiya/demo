<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

use App\Repositories\ForgotPasswordRepository;
use App\Interfaces\ForgotPasswordRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return $app->make(UserRepository::class);
        });
        $this->app->bind(ForgotPasswordRepositoryInterface::class, function ($app) {
            return $app->make(ForgotPasswordRepository::class);
        });
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return $app->make(CategoryRepository::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
