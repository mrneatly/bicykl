<?php

namespace Bicykl\Strategies;

use League\Container\Container;

interface AppStrategy
{
    public function initContainer(): static;
    public function boot(): static;
    public function getContainer(): Container;
}