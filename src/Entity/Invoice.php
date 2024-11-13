<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $total_amount = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $discount = null;

    #[ORM\Column]
    private ?int $product_id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $paymentMethod;

    private float $subtotal;

    private float $tax;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceItem::class, cascade: ['persist', 'remove'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->subtotal = 0.00;
        $this->tax = 0.00;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalAmount(): ? int
    {
        return $this->total_amount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->total_amount = $totalAmount;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getPaymentMethod(): string { return $this->paymentMethod; }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }


    public function addItem(InvoiceItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setInvoice($this); // Set bidirectional relationship
        }

        return $this;
    }

    public function removeItem(InvoiceItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            if ($item->getInvoice() === $this) {
                $item->setInvoice(null); // Break association
            }
        }

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    // Getter and Setter for Subtotal
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    // Getter and Setter for Subtotal
    public function getTax(): float
    {
        return $this->tax;
    }

    public function setTax(float $subtotal): self
    {
        $this->tax = $subtotal;
        return $this;
    }
}
