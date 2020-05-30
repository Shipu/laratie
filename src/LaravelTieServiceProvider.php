<?php

namespace Shipu\Tie;

use Illuminate\Support\ServiceProvider;
use Shipu\Tie\Consoles\TieCommand;
use Shipu\Tie\Consoles\TieResourceCommand;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class LaravelTieServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            TieCommand::class,
            TieResourceCommand::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishConfig();
    }

    /**
     * Publish config.
     */
    protected function publishConfig()
    {
        $source = realpath(__DIR__.'/../config/tie.php');
        // Check if the application is a Laravel OR Lumen instance to properly merge the configuration file.
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('tie.php')], 'tie-config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('tie');
        }
        $this->mergeConfigFrom($source, 'tie');
    }
}
