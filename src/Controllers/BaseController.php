<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
    }

    /**
     * Rendre un template Twig.
     *
     * @param string $template
     * @param array $data
     */
    public function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }
}
