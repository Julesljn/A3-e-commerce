<?php

use App\Controllers\ProductController;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/../src/Views');
$twig = new Environment($loader);

$controller = new ProductController($twig);

$request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

// Routage
switch ($request) {
    case '':
    case '/':
        $controller->showHomePage();
        break;

    case '/crew':
        echo $twig->render('crew.twig');
        break;

    case '/destination':
        echo $twig->render('destination.twig');
        break;

    case '/technology':
        echo $twig->render('technology.twig');
        break;

    default:
        http_response_code(404);
        echo $twig->render('404.twig');
        break;
}
