<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ActionDatabaseRepository::class, \App\Repositories\ActionDatabaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DestinationOrReasonRepository::class, \App\Repositories\DestinationOrReasonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContractRepository::class, \App\Repositories\ContractRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HistoricRepository::class, \App\Repositories\HistoricRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RentAccessoryRepository::class, \App\Repositories\RentAccessoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScoreRepository::class, \App\Repositories\ScoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DeadFileRepository::class, \App\Repositories\DeadFileRepositoryEloquent::class);
        //:end-bindings:
    }
}
