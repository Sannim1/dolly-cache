<?php

namespace Skurian\Dolly;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Skurian\Dolly\BladeDirective;

class DollyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('cache', function ($expression) {
            return "<?php if (! app('Skurian\Dolly\BladeDirective')->setUp{$expression}) { ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php } echo app('Skurian\Dolly\BladeDirective')->tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BladeDirective::class, function () {
            return new BladeDirective(
                new RussianCaching(
                    app('cache.store')
                )
            );
        });
    }
}
