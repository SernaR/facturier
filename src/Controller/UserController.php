<?php

namespace App\Controller;

use App\Repository\DevisRepository;
use App\Repository\FactureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("user")
 *
 */
class UserController extends AbstractController
{
    #[Route('/', name: 'user_page')]
    public function index(FactureRepository $factureRepository, DevisRepository $devisRepository)
    {
        $devis = $devisRepository->showActiveQuotation();
        $factures = $factureRepository->findBy(array('payee'=>0));
        $contrats = $factureRepository->findMaintenanceContracts();

        return $this->render('user/dashboard.html.twig', array(
            'devis'=> $devis,
            'factures'=> $factures,
            'contrats' => $contrats
        ));
    }
}
