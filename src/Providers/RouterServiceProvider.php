<?php

namespace Bicykl\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

class RouterServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->getContainer()->add(Router::class, function () {
            $router = new Router();

            // @todo: take JsonStrategy into account too
            $strategy = new ApplicationStrategy();
            $strategy->setContainer($this->container);

            $router->setStrategy($strategy);

            return $router;
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === Router::class;
    }
}