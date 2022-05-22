<?php

namespace App\Service;

use App\Entity\InvoiceLines;
use App\Repository\InvoiceHeaderRepository;

class InvoiceCalculationsService
{
    /**
     * @param $invoiceLines
     * @return array|int
     */
    public function CalculateInvoiceLineNett($invoiceLines)
    {
        if (count($invoiceLines) != 0) {
            foreach ($invoiceLines as $invoiceLine) {
                {
                    $invoiceLineNett[$invoiceLine->getId()] = ((1 - $invoiceLine->getDiscount() / 100) * $invoiceLine->getProductPrice() * $invoiceLine->getQuantity());
                }
            }
            return $invoiceLineNett;
        } else {
            return 0;
        }

    }

    /**
     * @param $invoiceLines
     * @return array|int
     */

    public function CalculateInvoiceLineGross($invoiceLines)
    {
        if (count($invoiceLines) != 0) {
            foreach ($invoiceLines as $invoiceLine) {
                $invoiceLineGross[$invoiceLine->getId()] = ((1 - $invoiceLine->getDiscount() / 100) * $invoiceLine->getProductPrice() * $invoiceLine->getQuantity() * (1 + $invoiceLine->getProductVAT() / 100));
            }
            return $invoiceLineGross;
        } else {
            return 0;
        }
    }

    /**
     * @param $invoiceLines
     * @return float|int
     */
    public function CalculateInvoiceGross($invoiceLines)
    {
        $invoiceGross = 0;
        foreach ($invoiceLines as $invoiceLine) {
            $invoiceGross += $invoiceLinesGross[$invoiceLine->getId()] = ((1 - $invoiceLine->getDiscount() / 100) * $invoiceLine->getProductPrice() * $invoiceLine->getQuantity() * (1 + $invoiceLine->getProductVAT() / 100));
        }
        return $invoiceGross;
    }


}