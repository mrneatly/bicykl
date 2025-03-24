<?php

namespace Bicykl\Views;

use Bicykl\Config;
use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;

class TwigRuntimeExtension extends AbstractExtension
{
    public function __construct(
        protected ContainerInterface $container,
    )
    {
    }

    public function config(): Config
    {
        return $this->container->get(Config::class);
    }
}