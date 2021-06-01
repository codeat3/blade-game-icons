<?php

declare(strict_types=1);

namespace Codeat3\BladeGameIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeGameIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-game-icons', []);

            $factory->add('game-icons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-game-icons.php', 'blade-game-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-game-icons'),
            ], 'blade-game-icons');

            $this->publishes([
                __DIR__.'/../config/blade-game-icons.php' => $this->app->configPath('blade-game-icons.php'),
            ], 'blade-game-icons-config');
        }
    }

}
