<?php

use App\Controllers\ProductController;
use App\Controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

$productController = new ProductController();
$userController = new UserController();

$request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

// Routage
switch ($request) {
    case '':
    case '/':
        $productController->showHomePage();
        break;

    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->handleRegister();
        } else {
            $userController->showRegisterPage();
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->handleLogin();
        } else {
            $userController->showLoginPage();
        }
        break;

    default:
        http_response_code(404);
        $productController->render('404.twig');
        break;
}
