<?php

namespace Bicykl\Strategies;

use Bicykl\Providers\ConfigServiceProvider;
use Bicykl\Providers\IgnitionServiceProvider;
use Bicykl\Providers\RequestServiceProvider;
use Bicykl\Providers\RouterServiceProvider;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Strategy\StrategyInterface;

class HttpStrategy implements AppStrategy
{
    protected Dotenv $dotenv;

    protected Container $container;

    public function __construct(
        protected string $envFilePath,
        protected string $configFolderPath,
        protected StrategyInterface $routerStrategy,
    )
    {
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function getDotenv(): Dotenv
    {
        return $this->dotenv;
    }

    public function initContainer(): static
    {
        $this->container = \Bicykl\Container::getInstance();

        // enable autowiring (auto-resolving non-registered dependencies and also their inner dependencies)
        $this->container->delegate(new ReflectionContainer());

        return $this;
    }

    protected function initDotenv(string $envFilePath): static
    {
        $this->dotenv = Dotenv::createImmutable($envFilePath);
        $this->dotenv->load();

        return $this;
    }

    protected function initConfig(string $configPath): static
    {
        $this->container->addServiceProvider(
            new ConfigServiceProvider($configPath)
        );

        return $this;
    }

    public function boot(): static
    {
        $this->initDotenv($this->envFilePath);
        $this->initConfig($this->configFolderPath);

        $this->container
            ->addServiceProvider(new IgnitionServiceProvider())
            ->addServiceProvider(new RequestServiceProvider())
            ->addServiceProvider(new RouterServiceProvider());

        return $this;
    }
}