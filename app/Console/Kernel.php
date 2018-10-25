<?php

namespace App\Console;

use App\Console\Commands\AdjustTerminationData;
use App\Console\Commands\CheckUserOnline;
use App\Console\Commands\MigrateDeadFile;
use App\Console\Commands\MigrateFinancialContractCelebrated;
use App\Console\Commands\MigrateImmobileCaptured;
use App\Console\Commands\MigrateImmobileReleaseTermination;
use App\Console\Commands\MigrateRegisterContract;
use App\Console\Commands\MigrateTermination;
use App\Console\Commands\MigrateUser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MigrateTermination::class,
        MigrateDeadFile::class,
        MigrateImmobileReleaseTermination::class,
        MigrateRegisterContract::class,
        MigrateFinancialContractCelebrated::class,
        MigrateImmobileCaptured::class,
        MigrateUser::class,
        CheckUserOnline::class,
        AdjustTerminationData::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command(Test::class)->everyMinute();
        $schedule->command(CheckUserOnline::class)->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
