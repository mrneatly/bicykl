<?php

namespace Bicykl\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Spatie\Ignition\Ignition;

class IgnitionServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        // @todo only do that when debug mode is enabled
        Ignition::make()->register();
    }

    public function register(): void
    {
        //
    }

    public function provides(string $id): false
    {
        return false;
    }
}