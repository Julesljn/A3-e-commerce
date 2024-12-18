<?php

namespace App\Controllers;

use App\Repositories\ProductRepository;

class ProductController extends BaseController
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    public function showHomePage(): void
    {
        $products = $this->productRepository->findAll();

        $this->render('home.twig', [
            'products' => $products,
        ]);
    }

    public function showDetail(): void
    {
        $productId = $_GET['id'] ?? null;
        if (!$productId) {
            header('Location: /');
            exit;
        }

        $product = $this->productRepository->findById((int)$productId);
        if (!$product) {
            header('Location: /');
            exit;
        }

        $this->render('productDetail.twig', [
            'product' => $product,
        ]);
    }
    public function showCart(): void
    {
        $this->render('cart.twig');
    }
}
