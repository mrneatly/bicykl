<?php

namespace Bicykl\Strategies;

use League\Container\Container;

interface AppStrategy
{
    public function getContainer(): Container;
    public function initContainer(): static;
    public function build(): static;
}