<?php

namespace Bicykl;

use League\Container\Container;

class Bootstrapper
{
    public static function build(string $envFilePath, string $configFolderPath): Container
    {
        $builder = (new AppBuilder())
            ->initDotenv($envFilePath) // setting up an env file parser
            ->initContainer() // setting up a dependency container
            ->initConfig($configFolderPath); // setting up an app config manager

        return $builder->getContainer(); // returning updated dependency container
    }
}