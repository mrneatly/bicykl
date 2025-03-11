<?php

namespace Bicykl\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\StrategyInterface;

class RouterServiceProvider extends AbstractServiceProvider
{
    public function __construct(
        protected ?StrategyInterface $routerStrategy = null,
    )
    {
    }

    public function register(): void
    {
        $this->getContainer()->add(Router::class, function () {
            $router = new Router();
            $router->setStrategy($this->getStrategy());

            return $router;
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === Router::class;
    }

    private function getStrategy(): StrategyInterface
    {
        if (!$this->routerStrategy) {
            $this->routerStrategy = new ApplicationStrategy();
        }

        if (!$this->routerStrategy->getContainer()) {
            $this->routerStrategy->setContainer($this->container);
        }

        return $this->routerStrategy;
    }
}