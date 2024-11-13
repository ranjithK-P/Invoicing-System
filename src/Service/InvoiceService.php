<?php
// src/Service/InvoiceService.php
namespace App\Service;

use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createInvoice($customerId, $products, float $flatDiscount = 0, float $taxRate = 0, string $paymentMethod = 'Cash'): Invoice
    {
        $invoice = new Invoice();
        // $invoice->setCustomer($customer);
        $invoice->setPaymentMethod($paymentMethod);
        $subtotal = 0;
        $flatDiscount = 0;

        foreach ($products as $productData) {
            $product = $this->em->getRepository(Product::class)->find($productData['id']);
            if (!$product) {
                throw new \Exception("Product not found with ID " . $productData['id']);
            }
            // Debugging: Confirm product retrieval
            if ($product === null) {
                throw new \Exception("Product retrieval failed. ID: " . $productData['id']);
            }
          
            $invoiceItem = new InvoiceItem();
            $invoiceItem->setProductId($productData['id']);
            $invoiceItem->setCustomerId($customerId);
            $invoiceItem->setQuantity($productData['quantity']);
            $invoiceItem->setDiscount($productData['discount']);
            
            $total = ($product->getPrice() * $productData['quantity']) - $productData['discount'];

            $invoiceItem->setTotalAmount($total);

            $invoice->addItem($invoiceItem);

            // Explicitly persist each item
            $this->em->persist($invoiceItem);
        }

        // Apply flat discount
        $subtotal = $total - $flatDiscount;
        $invoice->setSubtotal($subtotal);
        $invoice->setDiscount($flatDiscount);

        // Apply tax
        $taxAmount = $subtotal * ($taxRate / 100);
        $invoice->setTax($taxAmount);

        // Calculate total
        $total = $subtotal + $taxAmount;
        $invoice->setTotalAmount($total);

        $this->em->persist($invoice);
        $this->em->flush();

        return $invoice;
    }
  
}



?>