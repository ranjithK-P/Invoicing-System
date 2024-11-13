<?php
// src/Controller/InvoiceController.php
namespace App\Controller;

use App\Entity\Customer;
use App\Service\InvoiceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    private InvoiceService $invoiceService;
    private EntityManagerInterface $em;

    public function __construct(InvoiceService $invoiceService, EntityManagerInterface $em)
    {
        $this->invoiceService = $invoiceService;
        $this->em = $em;
    }

    #[Route('/invoice/generate', name: 'generate_invoice', methods: ['POST'])]
    public function generateInvoice(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $customerId = $data['customer_id'] ?? null;
        $products = $data['products'] ?? [];
        $flatDiscount = $data['flat_discount'] ?? 0;
        $taxRate = $data['tax_rate'] ?? 0;
        $paymentMethod = $data['payment_method'] ?? 'Cash';
        $customer = $this->em->getRepository(Customer::class)->find($customerId);

        if (!$customer) {
            return $this->json(['error' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        // Ensure customer ID is provided and is valid
        if (!$customerId || !is_numeric($customerId)) {
            return $this->json(['error' => 'Invalid or missing customer ID'], Response::HTTP_BAD_REQUEST);
        }

        $invoice = $this->invoiceService->createInvoice($customerId, $products, $flatDiscount, $taxRate, $paymentMethod);

        return $this->json([
            'invoice_id' => $invoice->getId(),
            'total' => $invoice->getTotalAmount(),
            'tax' => $invoice->getTax(),
            'discount' => $invoice->getDiscount(),
            'items' => array_map(fn($item) => [
                'product_id' => $item->getProductId(),
                'quantity' => $item->getQuantity(),
                'price' => $item->getPrice(),
                'discount' => $item->getDiscount(),
                'total' => $item->getTotalAmount()
            ], $invoice->getItems()->toArray()),
        ]);
    }
}


?>