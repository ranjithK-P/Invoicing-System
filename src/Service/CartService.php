<?php
// src/Service/CartService.php
namespace App\Service;

use App\Entity\Product;
use App\Model\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->session = $requestStack->getSession();
        $this->em = $em;
    }

    // Adding the product and checking the quantity before adding
    public function addProduct(int $productId, int $quantity): bool
    {
        $product = $this->em->getRepository(Product::class)->find($productId);

        if (!$product || $product->getQuantity() < $quantity) {
            return false; // Product not available or insufficient stock
        }

        // Retrieve the current cart from the session
        $cart = $this->session->get('cart', []);

        if (isset($cart[$productId])) {
            // If the item is already in the cart, update the quantity
            $cart[$productId]->setQuantity($cart[$productId]->getQuantity() + $quantity);
        } else {
            // If the item is not in the cart, create a new CartItem
            $cart[$productId] = new CartItem(
                $product->getId(),
                $product->getName(),
                $product->getPrice(),
                $quantity
            );
        }

        // Save the updated cart back to the session
        $this->session->set('cart', $cart);

        return true;
    }


    public function getCart(): array
    {
        $cart = $this->session->get('cart', []);

        return array_map(fn($item) => $item->toArray(), $cart);
    }
}

?>