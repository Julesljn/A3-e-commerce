<?php

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Twig\Environment;

class ProductController
{
    private ProductRepository $productRepository;
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->productRepository = new ProductRepository();
        $this->twig = $twig;
    }

    public function showHomePage(): void
    {
        $products = $this->productRepository->findAll();

        echo $this->twig->render('home.twig', [
            'products' => $products
        ]);
    }
}
