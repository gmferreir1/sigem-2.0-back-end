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
        $this->app->bind(\App\Repositories\ImmobileReleaseRepository::class, \App\Repositories\ImmobileReleaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DocumentationRepository::class, \App\Repositories\DocumentationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReserveContractRepository::class, \App\Repositories\ReserveContractRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScoreAttendanceRepository::class, \App\Repositories\ScoreAttendanceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HistoricRepository::class, \App\Repositories\HistoricRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContractCelebratedRepository::class, \App\Repositories\ContractCelebratedRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReserveReasonCancelRepository::class, \App\Repositories\ReserveReasonCancelRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScoreAttendantRepository::class, \App\Repositories\ScoreAttendantRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReasonRepository::class, \App\Repositories\ReasonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContractRepository::class, \App\Repositories\ContractRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HistoricRepository::class, \App\Repositories\HistoricRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReportListRepository::class, \App\Repositories\ReportListRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ControlLetterRepository::class, \App\Repositories\ControlLetterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SendLetterRepository::class, \App\Repositories\SendLetterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReserveSendLetterRepository::class, \App\Repositories\ReserveSendLetterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecoveryPasswordTokenRepository::class, \App\Repositories\RecoveryPasswordTokenRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SystemGoalRepository::class, \App\Repositories\SystemGoalRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MessageRepository::class, \App\Repositories\MessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OnlineUserRepository::class, \App\Repositories\OnlineUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SystemAlertRepository::class, \App\Repositories\SystemAlertRepositoryEloquent::class);
        //:end-bindings:
    }
}
