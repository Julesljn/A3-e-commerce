<?php

namespace App\Controllers;

use App\Repositories\OrderRepository;

class OrderController extends BaseController
{
    private OrderRepository $orderRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = new OrderRepository();
    }

    public function placeOrder(): void
    {
        header('Content-Type: application/json');
        $userId = $_SESSION['userId'] ?? 1;

        $cartJson = $_POST['cart'] ?? null;
        if (!$cartJson) {
            http_response_code(400);
            echo json_encode(['error' => 'Aucun panier fourni']);
            return;
        }

        $cart = json_decode($cartJson, true);
        if (empty($cart)) {
            http_response_code(400);
            echo json_encode(['error' => 'Panier vide']);
            return;
        }

        $orderId = $this->orderRepository->createOrder($userId);

        $totalAmount = 0;
        foreach ($cart as $item) {
            $productId = (int) $item['id'];
            $quantity = (int) $item['quantity'];

            for ($i = 0; $i < $quantity; $i++) {
                $this->orderRepository->addProductToOrder($orderId, $productId);
                $totalAmount += $item['price'];
            }
        }
        $paymentResult = $this->processPayment($orderId, $totalAmount);

        if ($paymentResult['status'] === 'requires_confirmation') {
            echo json_encode([
                'success' => true,
                'orderId' => $orderId,
                'clientSecret' => $paymentResult['clientSecret'],
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la création du paiement']);
        }
    }

    public function processPayment($orderId, $amount): array
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        \Stripe\Stripe::setApiKey('sk_test_51QXKgGPVlFxktLOkTWEzCVlIJcPqj9PiVcLmLoZ3pqBMvtesDCjRbCLGjjt0SD5uUaChRlmXQ7wit1IW0IVyJY0C00b5zx9C1m');

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100, // Montant en centimes
                'currency' => 'eur',
                'metadata' => ['order_id' => $orderId],
            ]);

            // Retourner uniquement le client_secret
            return [
                'status' => 'requires_confirmation',
                'clientSecret' => $paymentIntent->client_secret,
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Erreur Stripe: ' . $e->getMessage());
            return ['status' => 'failed', 'error' => $e->getMessage()];
        }
    }
    public function confirmPayment(): void
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $orderId = $input['orderId'] ?? null;
        $status = $input['status'] ?? null;

        if (!$orderId || !$status) {
            http_response_code(400);
            echo json_encode(['error' => 'Données de paiement invalides']);
            return;
        }

        $paymentStatus = $status === 'succeeded' ? 'Completed' : 'Failed';

        try {
            $this->orderRepository->addPayment([
                'method' => 'Stripe',
                'status' => $paymentStatus,
                'orderId' => $orderId,
            ]);

            echo json_encode([
                'success' => true,
                'message' => $paymentStatus === 'Completed' ? 'Paiement réussi et enregistré.' : 'Paiement échoué et enregistré.',
            ]);
        } catch (\Exception $e) {
            error_log('Erreur lors de l\'enregistrement du paiement : ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de l\'enregistrement du paiement.']);
        }
    }
}
