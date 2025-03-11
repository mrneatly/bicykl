<?php

namespace Bicykl\Strategies;

use Bicykl\Providers\IgnitionServiceProvider;
use Bicykl\Providers\RequestServiceProvider;
use Bicykl\Providers\RouterServiceProvider;
use League\Route\Strategy\StrategyInterface;

class HttpStrategy extends AbstractAppStrategy
{
    public function __construct(
        protected string $envFilePath,
        protected string $configFolderPath,
        protected ?StrategyInterface $routerStrategy = null,
    )
    {
    }

    public function boot(): static
    {
        $this->initDotenv($this->envFilePath);
        $this->initConfig($this->configFolderPath);

        $this->getContainer()
            ->addServiceProvider(new IgnitionServiceProvider())
            ->addServiceProvider(new RequestServiceProvider())
            ->addServiceProvider(new RouterServiceProvider($this->routerStrategy));

        return $this;
    }
}