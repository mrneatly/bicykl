<?php

namespace Bicykl;

use League\Container\Container as BaseContainer;

class Container
{
    protected static ?BaseContainer $instance = null;

    public static function getInstance(): BaseContainer
    {
        if (is_null(static::$instance)) {
            static::$instance = new BaseContainer();
        }

        return static::$instance;
    }
}