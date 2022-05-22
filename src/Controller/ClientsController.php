<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use App\Repository\ClientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ClientsController extends AbstractController
{
    private $clientsRepository;

    public function __construct(ClientsRepository $clientsRepository)
    {
        $this->clientsRepository = $clientsRepository;
    }

    #[Route('/clients', methods: ['GET'], name: 'app_clients')]
    public function index(): Response
    {
        $clients = $this->clientsRepository->findAll();
        return $this->render('clients/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/clients/new', name: 'app_clients_new')]
    public function new(Request $request): Response
    {
        $newClient = new Clients();
        $formClient = $this->createForm(ClientsType::class, $newClient);
        $formClient->handleRequest($request);
        if ($formClient->isSubmitted() && $formClient->isValid()) {
            $newClient = $formClient->getData();
            $newClient->addInvoiceHeadersSellFrom();
            $newClient->addInvoiceHeadersSellTo();
            $this->clientsRepository->add($newClient, true);
            $this->addFlash('success', 'Klient został dodany');
            return $this->redirectToRoute('app_invoice_conroller');
        } else {
            $this->addFlash('error', 'coś poszło nie tak!');
        }
        return $this->render('clients/new.html.twig', [
            'formClient' => $formClient->createView()
        ]);
    }
}
