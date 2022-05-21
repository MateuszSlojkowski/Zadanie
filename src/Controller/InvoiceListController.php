<?php

namespace App\Controller;

use App\Entity\InvoiceHeader;
use App\Entity\InvoiceLines;
use App\Form\CreateInvoiceHeaderType;
use App\Form\InvoiceLinesType;
use App\Repository\InvoiceHeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductsRepository;
use App\Repository\InvoiceLinesRepository;

class InvoiceListController extends AbstractController
{
    private $invoiceHeaderRepository;
    private $em;
    private $invoiceLinesRepository;

    public function __construct(InvoiceHeaderRepository $invoiceHeaderRepository, EntityManagerInterface $em, InvoiceLinesRepository $invoiceLinesRepository)
    {
        $this->invoiceHeaderRepository = $invoiceHeaderRepository;
        $this->em = $em;
        $this->invoiceLinesRepository = $invoiceLinesRepository;
    }

    //showing all invoice headers
    #[Route('/invoicelist', methods: ['GET'], name: 'app_invoice_list_conroller')]
    public function index(): Response
    {
        $invoiceheaders = $this->invoiceHeaderRepository->findAll();

        return $this->render('invoice_list_conroller/index.html.twig', [
            'invoiceheaders' => $invoiceheaders
        ]);
    }

    //showing one invoice
    #[Route('/invoicelist/{id}', name: 'app_invoice_conroller')]
    public function show(Request $request, $id): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        $invoiceLine = new InvoiceLines();
        $formInvoiceLine = $this->createForm(InvoiceLinesType::class, $invoiceLine);
        $formInvoiceLine->handleRequest($request);
        if ($formInvoiceLine->isSubmitted()) {
            $newInvoiceLine = $formInvoiceLine->getData();
            $newInvoiceLine->setproductType($newInvoiceLine->getProductId()->getType());

            if ($formInvoiceLine->isValid()) {

            }
        }

        return $this->render('invoice_list_conroller/invoice.html.twig', [
            'invoiceheader' => $invoiceHeader,
            'formInvoiceLine' => $formInvoiceLine->createView()
            //'invoicelines' => $this->invoiceLinesRepository->find([)
        ]);
    }

    #[Route('/', name: 'index')]
    public function createInvoiceHeader(Request $request): Response
    {
        $invoiceHeader = new InvoiceHeader();
        $formInvoiceHeader = $this->createForm(CreateInvoiceHeaderType::class, $invoiceHeader);
        //taking data inputed by user from form
        $formInvoiceHeader->handleRequest($request);
        //checking data from form and sending to database
        if ($formInvoiceHeader->isSubmitted() && $formInvoiceHeader->isValid()) {
            $newInvoiceHeader = $formInvoiceHeader->getData();
            $newInvoiceHeader->setPostingDate(new \DateTime());
            $newInvoiceHeader->setUser($this->getUser());
            $newInvoiceHeader->setType("Proforma");

            $this->em->persist($newInvoiceHeader);
            $this->em->flush();
            $this->addFlash('success', 'Nagłówek FV został utworzony');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $newInvoiceHeader->getId()]);
        }

        return $this->render('index/index.html.twig', [
            'formInvoiceHeader' => $formInvoiceHeader->createView()
        ]);
    }

    #[Route('/invoicelist/edit/{id}', name: 'edit_invoice')]
    public function editInvoiceHeader($id, Request $request): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        $formInvoiceHeader = $this->createForm(CreateInvoiceHeaderType::class, $invoiceHeader);
        $formInvoiceHeader->handleRequest($request);
        if ($formInvoiceHeader->isSubmitted() && $formInvoiceHeader->isValid()) {
            $newInvoiceHeader = $formInvoiceHeader->getData();
            if ($newInvoiceHeader->getType() != "Zaksięgowana") {
                $this->em->persist($newInvoiceHeader);
                $this->em->flush();
                $this->addFlash('success', 'Zmiany zostały naniesione');
                return $this->redirectToRoute('app_invoice_conroller', ['id' => $newInvoiceHeader->getId()]);
            } else {
                $this->addFlash('error', 'Nie można edytować zaksięgowanych Faktur, zrób korektę!');
            }
        }
        return $this->render('invoice_list_conroller/edit.thml.twig', [
            'formInvoiceHeader' => $formInvoiceHeader->createView(),
            'invoiceheader' => $invoiceHeader
        ]);
    }

    #[Route('/invoicelist/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_invoiceHeader')]
    public function deleteInvoiceHeader($id): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        if ($invoiceHeader->getType() != "Zaksięgowana") {
            $this->em->remove($invoiceHeader);
            $this->em->flush();
            $this->addFlash('success', 'Faktura proforma została wykasowana');
            return $this->redirectToRoute('app_invoice_list_conroller');
        } else {
            $this->addFlash('error', 'Nie można kasować zaksięgowanych Faktur, zrób korektę!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        }
    }

    #[Route('/invoicelist/post/{id}', name: 'post_invoice')]
    public function postInvoiceHeader($id, Request $request): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);

        if ($invoiceHeader->getType() != "Zaksięgowana") {
            $invoiceHeader->setType("Zaksięgowana");
            $this->em->persist($invoiceHeader);
            $this->em->flush();
            $this->addFlash('success', 'Faktura zostałą zaksięgowana!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        } else {
            $this->addFlash('error', 'Ta Faktura już jest zaksięgowana, nie możesz jej księgować ponownie!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        }
    }
}
