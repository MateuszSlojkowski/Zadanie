<?php

namespace App\Controller;

use App\Entity\InvoiceHeader;
use App\Entity\InvoiceLines;
use App\Form\CreateInvoiceHeaderType;
use App\Form\InvoiceLinesType;
use App\Repository\InvoiceHeaderRepository;
use App\Service\InvoiceCalculationsService;
use App\Service\TakeDataFromProductService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InvoiceLinesRepository;

/**
 * @IsGranted("ROLE_USER")
 */
class InvoiceListController extends AbstractController
{
    private $invoiceHeaderRepository;
    private $em;
    private $invoiceLinesRepository;

    /**
     * @param InvoiceHeaderRepository $invoiceHeaderRepository
     * @param EntityManagerInterface $em
     * @param InvoiceLinesRepository $invoiceLinesRepository
     */
    public function __construct(InvoiceHeaderRepository $invoiceHeaderRepository, EntityManagerInterface $em, InvoiceLinesRepository $invoiceLinesRepository)
    {
        $this->invoiceHeaderRepository = $invoiceHeaderRepository;
        $this->em = $em;
        $this->invoiceLinesRepository = $invoiceLinesRepository;
    }

    /**
     * @param $id
     * @return Response
     */
    #[Route('/invoicelist/deleteline/{id}', methods: ['GET', 'DELETE'], name: 'delete_invoiceLine')]
    public function deleteInvoiceLine($id): Response
    {
        $invoiceLine = $this->invoiceLinesRepository->find($id);
        $invoiceHeader = $invoiceLine->getInvoiceId();
        if ($invoiceHeader->getType() != "Zaksięgowana") {
            $this->em->remove($invoiceLine);
            $this->em->flush();
            $this->addFlash('success', 'Linia FV została wykasowana!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        } else {
            $this->addFlash('error', 'Nie można kasować linii z zaksięgowanych Faktur, zrób korektę!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        }
    }

    /**
     * @return Response
     */

    #[Route('/invoicelist', methods: ['GET'], name: 'app_invoice_list_conroller')]
    public function index(): Response
    {
        $invoiceHeaders = $this->invoiceHeaderRepository->findAll();

        return $this->render('invoice_list_conroller/index.html.twig', [
            'invoiceHeaders' => $invoiceHeaders
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param TakeDataFromProductService $takeDataFromProductService
     * @param InvoiceCalculationsService $invoiceCalculationsService
     * @return Response
     */
    #[Route('/invoicelist/{id}', name: 'app_invoice_conroller')]
    public function show(Request $request, $id, TakeDataFromProductService $takeDataFromProductService, InvoiceCalculationsService $invoiceCalculationsService): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        $invoiceLine = new InvoiceLines();
        $formInvoiceLine = $this->createForm(InvoiceLinesType::class, $invoiceLine);
        $formInvoiceLine->handleRequest($request);
        if ($formInvoiceLine->isSubmitted()) {
            $newInvoiceLine = $formInvoiceLine->getData();
            //this function is copying data from Product to Invoice Line
            $takeDataFromProductService->takeDataFromProduct($newInvoiceLine);
            $newInvoiceLine->setinvoiceId($invoiceHeader);
            $newInvoiceLine->setuser($this->getUser());
            if (!$formInvoiceLine->isValid()) {
                $this->addFlash('error', 'Sprawdź poprawność danych!');
            } elseif ($invoiceHeader->getType() != "Zaksięgowana") {
                $this->em->persist($newInvoiceLine);
                $this->em->flush();
                $this->addFlash('success', 'Linia została utworzona!');
            } else {
                $this->addFlash('error', 'Nie możesz dodawać linii do zaksięgowanej FV!');
            }

        }
        return $this->render('invoice_list_conroller/invoice.html.twig', [
            'invoiceHeader' => $invoiceHeader,
            'formInvoiceLine' => $formInvoiceLine->createView(),
            'invoiceLines' => $this->invoiceLinesRepository->findBy(['invoiceId' => $id], []),
            'invoiceLineNett' => $invoiceCalculationsService->calculateInvoiceLineNett($this->invoiceLinesRepository->findBy(['invoiceId' => $id], [])),
            'invoiceLineGross' => $invoiceCalculationsService->calculateInvoiceLineGross($this->invoiceLinesRepository->findBy(['invoiceId' => $id], [])),
            'invoiceGross' => $invoiceCalculationsService->calculateInvoiceGross($this->invoiceLinesRepository->findBy(['invoiceId' => $id], []))
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function createInvoiceHeader(Request $request): Response
    {
        $invoiceHeader = new InvoiceHeader();
        $formInvoiceHeader = $this->createForm(CreateInvoiceHeaderType::class, $invoiceHeader);
        $formInvoiceHeader->handleRequest($request);
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

    /**
     * @param $id
     * @param Request $request
     * @return Response
     */
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

    /**
     * @param $id
     * @return Response
     */
    #[Route('/invoicelist/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_invoiceHeader')]
    public function deleteInvoiceHeader($id): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        if ($invoiceHeader->getType() != "Zaksięgowana") {
            $invoiceLines = $this->invoiceLinesRepository->findBy(['invoiceId' => $id]);
            foreach ($invoiceLines as $invoiceLine) {
                $this->em->remove($invoiceLine);
                $this->em->flush();
            }
            $this->em->remove($invoiceHeader);
            $this->em->flush();
            $this->addFlash('success', 'Faktura proforma została wykasowana');
            return $this->redirectToRoute('app_invoice_list_conroller');
        } else {
            $this->addFlash('error', 'Nie można kasować zaksięgowanych Faktur, zrób korektę!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return Response
     */
    #[Route('/invoicelist/post/{id}', name: 'post_invoice')]
    public function postInvoiceHeader($id, Request $request): Response
    {
        $invoiceHeader = $this->invoiceHeaderRepository->find($id);
        $LastInvoiceHeader = $this->invoiceHeaderRepository->findBy(['type' => 'Zaksięgowana'], ['type' => 'DESC']);

        if ($invoiceHeader->getType() != "Zaksięgowana") {
            $invoiceHeader->setType("Zaksięgowana");
            $invoiceHeader->setPostingDate(new \DateTime());
            $invoiceHeader->setNr(strval(count($LastInvoiceHeader) + 1));
            $this->em->persist($invoiceHeader);
            $this->em->flush();
            $this->addFlash('success', 'Faktura zostałą zaksięgowana! Nowy numer został nadany automatycznie.');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        } else {
            $this->addFlash('error', 'Ta Faktura już jest zaksięgowana, nie możesz jej księgować ponownie!');
            return $this->redirectToRoute('app_invoice_conroller', ['id' => $invoiceHeader->getId()]);
        }
    }
}
