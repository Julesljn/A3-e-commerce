<?php

namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Database\Database;
use Twig\Environment;

class ProductController
{
    private ProductRepository $productRepository;
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->productRepository = new ProductRepository(Database::getConnection());
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
