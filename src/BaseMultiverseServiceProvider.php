<?php

namespace Aleksandar\Multiverse;

use Aleksandar\Multiverse\Services\BaseConverter;
use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Illuminate\Support\ServiceProvider;

class BaseMultiverseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/multiverse.php' => config_path('multiverse.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/multiverse.php', 'base-multiverse');
        $this->app->bind(ConversionPolicyInterface::class, BaseConverter::class);
    }
}
