<?php

namespace GeneaLabs\CashierPaypal\ServiceProviders;

use GeneaLabs\CashierPaypal\Cashier as GeneaLabsCashier;
use Illuminate\Support\ServiceProvider;
use GeneaLabs\CashierPaypal\Console\Commands\CashierInstall;
use GeneaLabs\CashierPaypal\Console\Commands\CashierRun;
use GeneaLabs\CashierPaypal\Order\Contracts\MinimumPayment as MinimumPaymentContract;
use GeneaLabs\CashierPaypal\Coupon\ConfigCouponRepository;
use GeneaLabs\CashierPaypal\Coupon\Contracts\CouponRepository;
use GeneaLabs\CashierPaypal\Plan\ConfigPlanRepository;
use GeneaLabs\CashierPaypal\Plan\Contracts\PlanRepository;

class Cashier extends ServiceProvider
{
    // const PACKAGE_VERSION = '1.3.0';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/webhooks.php');
        $this->mergeConfig();
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cashier');

        // mollie()->addVersionString('MollieLaravelCashier/' . self::PACKAGE_VERSION);

        if ($this->app->runningInConsole()) {
            $this->publishMigrations();
            $this->publishConfig('cashier-configs');
            $this->publishViews('cashier-views');
        }

        $this->registerMigrations();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(PlanRepository::class, ConfigPlanRepository::class);
        $this->app->singleton(CouponRepository::class, function () {
            return new ConfigCouponRepository(
                config('cashier_coupons.defaults'),
                config('cashier_coupons.coupons')
            );
        });
        $this->app->bind(MinimumPaymentContract::class, MinimumPayment::class);

        $this->commands([
            CashierInstall::class,
            CashierRun::class,
        ]);

        $this->app->register(Event::class);
    }

    protected function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cashier.php', 'cashier');
        $this->mergeConfigFrom(__DIR__ . '/../../config/cashier_coupons.php', 'cashier_coupons');
        $this->mergeConfigFrom(__DIR__ . '/../../config/cashier_plans.php', 'cashier_plans');
        $this->mergeConfigFrom(__DIR__ . '/../../config/services.php', 'services');
    }

    protected function publishMigrations()
    {
        $this->publishes(
            [
                __DIR__ . '/../../database/migrations' => database_path('migrations'),
            ],
            'migrations'
        );
    }

    protected function registerMigrations()
    {
        if (GeneaLabsCashier::$runsMigrations) {
            return $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    protected function publishConfig(string $tag)
    {
        $this->publishes([
            __DIR__ . '/../../config/cashier.php' => config_path('cashier.php'),
            __DIR__ . '/../../config/cashier_coupons.php' => config_path('cashier_coupons.php'),
            __DIR__ . '/../../config/cashier_plans.php' => config_path('cashier_plans.php'),
        ], $tag);
    }

    protected function publishViews(string $tag)
    {
        $this->publishes([
            __DIR__ . '/../../resources/views' => $this->app->basePath('resources/views/vendor/cashier'),
        ], $tag);
    }
}
