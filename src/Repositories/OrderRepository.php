<?php

namespace App\Repositories;

use App\Database\Database;

class OrderRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createOrder(int $userId): int
    {
        $data = ['userId' => $userId];
        return $this->db->create('order', $data);
    }

    public function addProductToOrder(int $orderId, int $productId): int
    {
        $data = [
            'orderId' => $orderId,
            'productId' => $productId,
        ];

        return $this->db->create('order-product', $data);
    }

    public function getAllOrdersWithDetails(): array
    {
        $sql = "
    SELECT
        o.id AS order_id,
        u.id AS user_id,
        u.firstname,
        u.lastname,
        p.id AS product_id,
        p.name AS product_name,
        p.price AS product_price,
        pay.status AS payment_status
    FROM `order` o
    LEFT JOIN `user` u ON o.userId = u.id
    LEFT JOIN `order-product` op ON o.id = op.orderId
    LEFT JOIN `product` p ON op.productId = p.id
    LEFT JOIN `payment` pay ON o.id = pay.orderId
    ORDER BY o.id ASC
    ";

        $results = $this->db->customRead($sql);

        $orders = [];
        foreach ($results as $row) {
            $orderId = $row['order_id'];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $orderId,
                    'user' => [
                        'id' => $row['user_id'],
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                    ],
                    'products' => [],
                    'payment' => [
                        'status' => $row['payment_status'] ?? 'Non payé',
                    ],
                ];
            }

            if ($row['product_id']) {
                $orders[$orderId]['products'][] = [
                    'id' => $row['product_id'],
                    'name' => $row['product_name'],
                    'price' => $row['product_price'],
                ];
            }
        }

        return array_values($orders);
    }

    public function addPayment(array $paymentData): int
    {
        try {
            error_log('Ajout du paiement : ' . print_r($paymentData, true));

            return $this->db->create('payment', [
                'method' => $paymentData['method'],
                'status' => $paymentData['status'],
                'orderId' => $paymentData['orderId'],
            ]);
        } catch (\PDOException $e) {
            error_log('Erreur lors de l\'ajout du paiement : ' . $e->getMessage());
            throw new \Exception('Erreur lors de l\'ajout du paiement.');
        }
    }
}
