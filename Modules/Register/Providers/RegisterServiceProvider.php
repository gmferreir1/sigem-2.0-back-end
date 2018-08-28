<?php

namespace Modules\Register\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Register\Repositories\Transfer\Contract\ContractRepository;
use Modules\Register\Repositories\Transfer\Contract\ContractRepositoryEloquent;
use Modules\Register\Repositories\Transfer\ScoreAttendant\ScoreAttendantRepository;
use Modules\Register\Repositories\Transfer\ScoreAttendant\ScoreAttendantRepositoryEloquent;
use Modules\Register\Repositories\ReserveContract\ReserveContractRepository;
use Modules\Register\Repositories\ReserveContract\ReserveContractRepositoryEloquent;
use Modules\Register\Repositories\ReserveHistoric\ReserveHistoricRepository;
use Modules\Register\Repositories\ReserveHistoric\ReserveHistoricRepositoryEloquent;
use Modules\Register\Repositories\ReserveReasonCancel\ReserveReasonCancelRepository;
use Modules\Register\Repositories\ReserveReasonCancel\ReserveReasonCancelRepositoryEloquent;
use Modules\Register\Repositories\ScoreAttendances\ScoreAttendanceRepository;
use Modules\Register\Repositories\ScoreAttendances\ScoreAttendanceRepositoryEloquent;
use Modules\Register\Repositories\Transfer\Reason\ReasonRepository;
use Modules\Register\Repositories\Transfer\Reason\ReasonRepositoryEloquent;

class RegisterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReserveContractRepository::class, ReserveContractRepositoryEloquent::class);
        $this->app->bind(ScoreAttendanceRepository::class, ScoreAttendanceRepositoryEloquent::class);
        $this->app->bind(ReserveHistoricRepository::class, ReserveHistoricRepositoryEloquent::class);
        $this->app->bind(ReserveReasonCancelRepository::class, ReserveReasonCancelRepositoryEloquent::class);
        $this->app->bind(ScoreAttendantRepository::class, ScoreAttendantRepositoryEloquent::class);
        $this->app->bind(ReasonRepository::class, ReasonRepositoryEloquent::class);
        $this->app->bind(ContractRepository::class, ContractRepositoryEloquent::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('register.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'register'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/register');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/register';
        }, \Config::get('view.paths')), [$sourcePath]), 'register');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/register');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'register');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'register');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
