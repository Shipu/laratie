<?php

namespace Shipu\Tie;

use Illuminate\Support\ServiceProvider;
use Shipu\Tie\Console\TieCommand;
use Shipu\Tie\Console\TieResourceCommand;

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
        $this->consoleCommand();
    }

    /**
     * Publish config.
     */
    protected function consoleCommand()
    {
        $source = realpath(__DIR__.'/../config/tie.php');
        // Check if the application is a Laravel OR Lumen instance to properly merge the configuration file.
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('tie.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('tie');
        }
        $this->mergeConfigFrom($source, 'tie');
    }
}
