<?php

namespace App\Controllers;

use App\Repositories\OrderRepository;

class AdminController extends BaseController
{
    private OrderRepository $orderRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = new OrderRepository();
    }

    public function showAdminPage(): void
    {
        $orders = $this->orderRepository->getAllOrdersWithDetails();

        $this->render('admin.twig', ['orders' => $orders]);

    }
}
