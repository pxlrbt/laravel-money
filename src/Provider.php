<?php

namespace Akaunting\Money;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/money.php' => config_path('money.php'),
        ], 'money');

        Money::setLocale($this->app->make('translator')->getLocale());
        Currency::setCurrencies($this->app->make('config')->get('money'));

        Blade::directive('money', function ($expression) {
            return "<?php echo money($expression); ?>";
        });

        Blade::directive('currency', function ($expression) {
            return "<?php echo currency($expression); ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/money.php', 'money');
    }
}
