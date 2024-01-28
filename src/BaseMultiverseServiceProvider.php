<?php

namespace Aleksandar\Multiverse;

use Aleksandar\Multiverse\Contracts\ValidatorInterface;
use Aleksandar\Multiverse\Services\BaseConverter;
use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\Validation\InputValidator;
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
        $this->app->bind(ValidatorInterface::class, InputValidator::class);
        $this->app->bind(ConversionPolicyInterface::class, BaseConverter::class);
    }
}
