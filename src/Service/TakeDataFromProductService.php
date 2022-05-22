<?php

namespace App\Service;

class TakeDataFromProductService
{

    //this function is copying data from Product to Invoice Line

    public function takeDataFromProduct($newInvoiceLine)
    {
        $newInvoiceLine->setproductType($newInvoiceLine->getProductId()->getType());
        $newInvoiceLine->setproductName($newInvoiceLine->getProductId()->getName());
        $newInvoiceLine->setproductVAT($newInvoiceLine->getProductId()->getVAT());
        $newInvoiceLine->setproductMppRelevant($newInvoiceLine->getProductId()->isMppRelevant());
        $newInvoiceLine->setproductEAN($newInvoiceLine->getProductId()->getEAN());
        $newInvoiceLine->setproductDescription($newInvoiceLine->getProductId()->getDescription());
        $newInvoiceLine->setproductUnit($newInvoiceLine->getProductId()->getUnit());
        $newInvoiceLine->setproductPrice($newInvoiceLine->getProductId()->getPrice());
        return 0;
    }
}