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

    public function render(string $view, array $data = []): string
    {
        if (!str_ends_with($view, '.twig')) {
            $view .= '.twig';
        }

        return $this->twig->render($view, $data);
    }
}