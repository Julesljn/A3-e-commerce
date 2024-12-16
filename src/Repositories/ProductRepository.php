<?php

namespace App\Repositories;

use App\Models\Product;
use PDO;
use App\Database\Database;

class ProductRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findAll()
    {
        $fetchData = $this->db->read('product');
        $products = [];
        foreach ($fetchData as $row) {
            $products[] = new Product(
                name: $row['name'],
                price: (float) $row['price'],
                description: $row['description'],
                categoryId: (int) $row['categoryId'],
                brandId: (int) $row['brandId'],
                id: $row['id']
            );
        }
        return $products;
    }
}
