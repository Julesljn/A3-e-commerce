<?php

namespace App\Models;

class Product
{
    private ?int $id = null;
    private string $name;
    private float $price;
    private string $description;
    private int $categoryId;
    private int $brandId;

    public function __construct(
        string $name,
        float $price,
        string $description,
        int $categoryId,
        int $brandId,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->brandId = $brandId;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getBrandId(): int
    {
        return $this->brandId;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setBrandId(int $brandId): void
    {
        $this->brandId = $brandId;
    }
}
