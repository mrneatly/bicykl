<?php

namespace Bicykl;

use Bicykl\Providers\ConfigServiceProvider;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ReflectionContainer;

class AppBuilder
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

    public function initDotenv(string $envFilePath): static
    {
        $this->dotenv = Dotenv::createImmutable($envFilePath);
        $this->dotenv->load();

        return $this;
    }

    public function initContainer(): static
    {
        $this->container = \Bicykl\Container::getInstance();

        // enable autowiring (auto-resolving non-registered dependencies and also their inner dependencies)
        $this->container->delegate(new ReflectionContainer());

        return $this;
    }

    public function initConfig(string $configPath): static
    {
        $this->container->addServiceProvider(
            new ConfigServiceProvider($configPath)
        );

        return $this;
    }
}