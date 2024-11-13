<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class InvoiceItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $product_id;


    #[ORM\Column(type: 'integer')]
    private int $customer_id;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $discount;


    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceItem::class, cascade: ['persist', 'remove'])]
    private Collection $items;

    private float $total_amount = 0.0; 

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private Invoice $invoice;

    // Other properties...

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    // Set customerId as an integer
    public function setCustomerId(int $customerId): self
    {
        $this->customer_id = $customerId;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->discount;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }


    public function addItem(InvoiceItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setInvoice($this); // Ensure bidirectional relationship
        }

        return $this;
    }

    public function removeItem(InvoiceItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            if ($item->getInvoice() === $this) {
                $item->setInvoice(null); // Break association if needed
            }
        }

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;
        return $this;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function getTotalAmount(): float
    {
        return $this->total_amount;
    }

    public function setTotalAmount(): float
    {
        return $this->total_amount;
    }


    // Other getters and setters...
}

?>