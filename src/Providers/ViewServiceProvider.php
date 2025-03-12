<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use Bicykl\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\Extension\DebugExtension;
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

            $debugMode = $this->getContainer()->get(Config::class)->get('app.debug');

            $twig = new Environment($loader, [
                'cache' => false,
                'debug' => $debugMode,
            ]);

            if ($debugMode) {
                $twig->addExtension(new DebugExtension());
            }

            return new View($twig);
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === View::class;
    }
}