<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceLinesController extends AbstractController
{
    #[Route('/invoicelist/test/{id}', methods: ['GET'], name: 'app_invoice_lines')]
    public function index($id): Response
    {
        return $this->render('invoice_lines/index.html.twig', [
            'controller_name' => 'InvoiceLinesController',
        ]);
    }
}
