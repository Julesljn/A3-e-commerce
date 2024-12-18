<?php
session_start();

use App\Controllers\ProductController;
use App\Controllers\UserController;
use App\Controllers\OrderController;
use App\Controllers\AdminController;

require_once __DIR__ . '/../vendor/autoload.php';

$productController = new ProductController();
$userController = new UserController();
$orderController = new OrderController();

// On récupère la partie du chemin avant le "?"
$request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

// Routage
switch ($request) {
    case '':
    case '/':
        $productController->showHomePage();
        break;

    case '/product/detail':
        $productController->showDetail();
        break;

    case '/cart':
        $productController->showCart();
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

    case '/order/place':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->placeOrder();
        } else {
            http_response_code(405); // Méthode non autorisée
        }
        break;
    case '/admin':
        $adminController = new \App\Controllers\AdminController();
        $adminController->showAdminPage();
        break;
    case '/order/confirm-payment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->confirmPayment();
        } else {
            http_response_code(405);
        }
        break;

    default:
        http_response_code(404);
        $productController->render('404.twig');
        break;
}
