<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => false, 
            'debug' => true,
        ]);
    }

    protected function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }
}