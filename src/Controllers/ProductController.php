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
}
