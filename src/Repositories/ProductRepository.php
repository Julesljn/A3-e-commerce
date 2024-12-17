<?php

namespace App\Repositories;

use App\Models\Product;
use App\Database\Database;
use PDO;

class ProductRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getColorsByProductId(int $productId): array
    {
        $query = "
            SELECT c.name
            FROM `color-product` cp
            JOIN color c ON cp.colorId = c.id
            WHERE cp.productId = :productId
        ";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute(['productId' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getSizesByProductId(int $productId): array
    {
        $query = "
        SELECT s.size
        FROM `size-product` sp
        JOIN size s ON sp.sizeId = s.id
        WHERE sp.productId = :productId
    ";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute(['productId' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findAll(): array
    {
        $fetchData = $this->db->read('product');
        $products = [];

        foreach ($fetchData as $row) {
            $colors = $this->getColorsByProductId($row['id']);
            $sizes = $this->getSizesByProductId($row['id']);

            $products[] = new Product(name: $row['name'], price: (float) $row['price'], description: $row['description'], categoryId: (int) $row['categoryId'], brandId: (int) $row['brandId'], id: $row['id'], colors: $colors, sizes: $sizes);
        }

        return $products;
    }
}
