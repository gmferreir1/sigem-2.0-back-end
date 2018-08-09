<?php

namespace Modules\Termination\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Termination\Repositories\ContractRepository;
use Modules\Termination\Repositories\ContractRepositoryEloquent;
use Modules\Termination\Repositories\DestinationOrReasonRepository;
use Modules\Termination\Repositories\DestinationOrReasonRepositoryEloquent;
use Modules\Termination\Repositories\HistoricRepository;
use Modules\Termination\Repositories\HistoricRepositoryEloquent;
use Modules\Termination\Repositories\RentAccessoryRepository;
use Modules\Termination\Repositories\RentAccessoryRepositoryEloquent;
use Modules\Termination\Repositories\ScoreRepository;
use Modules\Termination\Repositories\ScoreRepositoryEloquent;

class TerminationServiceProvider extends ServiceProvider
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
        $this->app->bind(DestinationOrReasonRepository::class, DestinationOrReasonRepositoryEloquent::class);
        $this->app->bind(ContractRepository::class, ContractRepositoryEloquent::class);
        $this->app->bind(HistoricRepository::class, HistoricRepositoryEloquent::class);
        $this->app->bind(RentAccessoryRepository::class, RentAccessoryRepositoryEloquent::class);
        $this->app->bind(ScoreRepository::class, ScoreRepositoryEloquent::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('termination.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'termination'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/termination');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/termination';
        }, \Config::get('view.paths')), [$sourcePath]), 'termination');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/termination');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'termination');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'termination');
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
