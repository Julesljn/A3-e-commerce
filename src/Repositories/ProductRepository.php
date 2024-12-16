<?php

namespace App\Repositories;

use App\Models\Product;
use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->db->query($sql);

        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['name'],
                (float) $row['price'],
                $row['description'],
                (int) $row['categoryId'],
                (int) $row['brandId'],
                $row['id']
            );
        }

        return $products;
    }
}
