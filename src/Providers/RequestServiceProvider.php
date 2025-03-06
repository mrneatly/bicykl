<?php

namespace Bicykl\Providers;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

class RequestServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->getContainer()->add(ServerRequest::class, function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES,
            );
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === ServerRequest::class;
    }
}