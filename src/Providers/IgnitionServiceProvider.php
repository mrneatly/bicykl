<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Spatie\Ignition\Ignition;

class IgnitionServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        if ($this->getContainer()->get(Config::class)->get('app.debug')) {
            Ignition::make()->register();
        }
    }

    public function register(): void
    {
        //
    }

    public function provides(string $id): false
    {
        // "false" because we don't register any sub-dependencies in the register() method
        return false;
    }
}