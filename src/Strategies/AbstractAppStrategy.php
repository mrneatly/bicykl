<?php

namespace Bicykl\Strategies;

use Bicykl\Providers\ConfigServiceProvider;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ReflectionContainer;

abstract class AbstractAppStrategy implements AppStrategy
{
    protected Dotenv $dotenv;

    protected Container $container;

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
}