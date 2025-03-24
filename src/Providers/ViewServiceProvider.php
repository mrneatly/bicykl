<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use Bicykl\View;
use Bicykl\Views\TwigExtension;
use Bicykl\Views\TwigRuntimeLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class ViewServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected Environment $twig;

    public function __construct(
        protected string $viewsFolderPath,
    )
    {
    }

    public function boot(): void
    {
        $loader = new FilesystemLoader($this->viewsFolderPath);

        $debugMode = $this->getContainer()->get(Config::class)->get('app.debug');

        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => $debugMode,
        ]);

        $this->twig->addRuntimeLoader(new TwigRuntimeLoader($this->getContainer()));
        $this->twig->addExtension(new TwigExtension());

        if ($debugMode) {
            $this->twig->addExtension(new DebugExtension());
        }
    }

    public function register(): void
    {
        $this->getContainer()->add(View::class, function () {
            return new View($this->twig);
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === View::class;
    }
}