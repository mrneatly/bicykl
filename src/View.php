<?php

namespace Bicykl;

use Twig\Environment;

class View
{
    public function __construct(
        protected Environment $twig,
    )
    {
    }
}