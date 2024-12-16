<?php

require_once __DIR__ . '/../vendor/autoload.php';

$request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/Views');

$twig = new \Twig\Environment($loader);

switch ($request) {
    case '':
    case '/':
        echo $twig->render('home.twig');
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
