<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart/add', name: 'cart_add', methods: ['POST'])]
    public function addProduct(Request $request): Response
    {
        $productId = (int) $request->request->get('product_id');
        $quantity = (int) $request->request->get('quantity');

        if ($this->cartService->addProduct($productId, $quantity)) {
            return $this->json(['status' => 'success', 'message' => 'Product added to cart']);
        }

        return $this->json(['status' => 'error', 'message' => 'Product not available or insufficient stock'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/cart', name: 'cart_view', methods: ['GET'])]
    public function viewCart(): Response
    {
        $cart = $this->cartService->getCart();
        return $this->json(['cart' => $cart]);
    }
}
?>