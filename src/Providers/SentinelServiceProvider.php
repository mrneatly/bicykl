<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Cartalyst\Sentinel\Sentinel;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Cartalyst\Sentinel\Native\Facades\Sentinel as SentinelFacade;

class SentinelServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected Sentinel $sentinel;

    public function boot(): void
    {
        $bootstrapper = new SentinelBootstrapper(
            $this->getContainer()->get(Config::class)->get('auth')
        );

        /** @var SentinelFacade $sentinel */
        $sentinel = SentinelFacade::instance($bootstrapper);

        $this->sentinel = $sentinel->getSentinel();
    }

    public function register(): void
    {
        $this->getContainer()->add(Sentinel::class, function () {
            return $this->sentinel;
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === Sentinel::class;
    }
}