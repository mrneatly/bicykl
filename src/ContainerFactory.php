<?php

namespace Bicykl;

use Bicykl\Strategies\AppStrategy;
use League\Container\Container;

class ContainerFactory
{
    public static function build(AppStrategy $strategy): Container
    {
        $bootstrap = $strategy
            ->initContainer() // setting up a container
            ->build(); // booting the app (registering all required service providers)

        return $bootstrap->getContainer(); // returning updated dependency container
    }
}