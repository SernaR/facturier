<?php

namespace App\Controller;

use App\Repository\DevisRepository;
use App\Repository\FactureRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("user")
 * secu**************************
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_page")
     */
    public function index(FactureRepository $factureRepository, DevisRepository $devisRepository)
    {
        $devis = $devisRepository->showActiveQuotation();
        $factures = $factureRepository->findBy(array('payee'=>0));
        
        return $this->render('user/dashboard.html.twig', array(
            'devis'=> $devis,
            'factures'=> $factures
        ));
    }
}
