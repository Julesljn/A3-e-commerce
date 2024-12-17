<?php

namespace App\Models;

class Product
{
    private ?int $id;
    private string $name;
    private float $price;
    private string $description;
    private ?int $categoryId;
    private ?int $brandId;
    private array $colors;
    private array $sizes;

    public function __construct(
        string $name,
        float $price,
        string $description,
        ?int $categoryId = null,
        ?int $brandId = null,
        ?int $id = null,
        array $colors = [],
        array $sizes = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->brandId = $brandId;
        $this->colors = $colors;
        $this->sizes = $sizes;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getColors(): array { return $this->colors; }
    public function getSizes(): array { return $this->sizes; }
}
