<?php

namespace Modules\Sicadi\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Sicadi\Repositories\AddressRepository;
use Modules\Sicadi\Repositories\AddressRepositoryEloquent;
use Modules\Sicadi\Repositories\ClientContractRepository;
use Modules\Sicadi\Repositories\ClientContractRepositoryEloquent;
use Modules\Sicadi\Repositories\ClientRepository;
use Modules\Sicadi\Repositories\ClientRepositoryEloquent;
use Modules\Sicadi\Repositories\ContractRepository;
use Modules\Sicadi\Repositories\ContractRepositoryEloquent;
use Modules\Sicadi\Repositories\DjGuideRepository;
use Modules\Sicadi\Repositories\DjGuideRepositoryEloquent;
use Modules\Sicadi\Repositories\ImmobileRepository;
use Modules\Sicadi\Repositories\ImmobileRepositoryEloquent;
use Modules\Sicadi\Repositories\ImmobileTypeRepository;
use Modules\Sicadi\Repositories\ImmobileTypeRepositoryEloquent;
use Modules\Sicadi\Repositories\ImmobileVisitRepository;
use Modules\Sicadi\Repositories\ImmobileVisitRepositoryEloquent;
use Modules\Sicadi\Repositories\InactiveContractRepository;
use Modules\Sicadi\Repositories\InactiveContractRepositoryEloquent;
use Modules\Sicadi\Repositories\PhoneRepository;
use Modules\Sicadi\Repositories\PhoneRepositoryEloquent;
use Modules\Sicadi\Repositories\ReceiptTenantCompleteRepository;
use Modules\Sicadi\Repositories\ReceiptTenantCompleteRepositoryEloquent;
use Modules\Sicadi\Repositories\ReceiptTenantRepository;
use Modules\Sicadi\Repositories\ReceiptTenantRepositoryEloquent;
use Modules\Sicadi\Repositories\TenantAllContractRepository;
use Modules\Sicadi\Repositories\TenantAllContractRepositoryEloquent;
use Modules\Sicadi\Repositories\VisitRepository;
use Modules\Sicadi\Repositories\VisitRepositoryEloquent;

class SicadiServiceProvider extends ServiceProvider
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
        $this->app->bind(ClientContractRepository::class, ClientContractRepositoryEloquent::class);
        $this->app->bind(ClientRepository::class, ClientRepositoryEloquent::class);
        $this->app->bind(ContractRepository::class, ContractRepositoryEloquent::class);
        $this->app->bind(ImmobileRepository::class, ImmobileRepositoryEloquent::class);
        $this->app->bind(ImmobileTypeRepository::class, ImmobileTypeRepositoryEloquent::class);
        $this->app->bind(ImmobileVisitRepository::class, ImmobileVisitRepositoryEloquent::class);
        $this->app->bind(InactiveContractRepository::class, InactiveContractRepositoryEloquent::class);
        $this->app->bind(ReceiptTenantRepository::class, ReceiptTenantRepositoryEloquent::class);
        $this->app->bind(TenantAllContractRepository::class, TenantAllContractRepositoryEloquent::class);
        $this->app->bind(VisitRepository::class, VisitRepositoryEloquent::class);
        $this->app->bind(ReceiptTenantCompleteRepository::class, ReceiptTenantCompleteRepositoryEloquent::class);
        $this->app->bind(DjGuideRepository::class, DjGuideRepositoryEloquent::class);
        $this->app->bind(PhoneRepository::class, PhoneRepositoryEloquent::class);
        $this->app->bind(AddressRepository::class, AddressRepositoryEloquent::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('sicadi.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'sicadi'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/sicadi');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/sicadi';
        }, \Config::get('view.paths')), [$sourcePath]), 'sicadi');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/sicadi');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'sicadi');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'sicadi');
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
