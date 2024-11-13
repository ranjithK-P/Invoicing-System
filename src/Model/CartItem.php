<?php
// src/Model/CartItem.php
namespace App\Model;

class CartItem
{
    private int $productId;
    private string $productName;
    private float $price;
    private int $quantity;

    public function __construct(int $productId, string $productName, float $price, int $quantity)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getProductId(): int { return $this->productId; }
    public function getProductName(): string { return $this->productName; }
    public function getPrice(): float { return $this->price; }
    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }

    // Convert CartItem to an array for easy JSON serialization
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}


?>