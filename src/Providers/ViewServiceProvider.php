<?php

namespace Bicykl\Providers;

use Bicykl\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewServiceProvider extends AbstractServiceProvider
{
    public function __construct(
        protected string $viewsFolderPath,
    )
    {
    }

    public function register(): void
    {
        $this->getContainer()->add(View::class, function () {
            $loader = new FilesystemLoader($this->viewsFolderPath);

            $twig = new Environment($loader, [
                'cache' => false,
                'debug' => true,
            ]);

            return new View($twig);
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === View::class;
    }
}