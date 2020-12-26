<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\NotebookRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserImageUploadRepository;
use App\Repositories\UserVerificationRepository;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\NotebookRepositoryContract;
use App\Repositories\Contracts\PasswordResetRepositoryContract;
use App\Repositories\Contracts\UserVerificationRepositoryContract;
use App\Repositories\Contracts\UserImageUploadRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(NotebookRepositoryContract::class, NotebookRepository::class);
        $this->app->bind(PasswordResetRepositoryContract::class, PasswordResetRepository::class);
        $this->app->bind(UserImageUploadRepositoryContract::class, UserImageUploadRepository::class);
        $this->app->bind(UserVerificationRepositoryContract::class, UserVerificationRepository::class);
    }
}
