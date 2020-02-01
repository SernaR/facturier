<?php

namespace App\Controller;

use App\Entity\Accompte;
use App\Entity\Avoir;
use App\Entity\Devis;
use App\Entity\Facture;
use App\Form\GetClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("research")
* 
*/
class ResearchController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @Route("/", name="research")
    */
   public function index(Request $request, ClientRepository $clientRepository){

       $form = $this->createForm(GetClientType::class);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $nom = $form['nom']->getData();
           $clientFound = $clientRepository->findCustomer($nom);
           
           return $this->render('management/research.html.twig', array( 
               'clients' => $clientFound,
               'current_menu'=>'research',
           ));
       }
       
       return $this->render('management/research.html.twig', array(
           'clients' => [],
           'form' => $form->createView(),
           'current_menu'=>'research',
           
       ));
   }
   
   /**
    * @Route("/{devis}/findQuotation", name="research_quotation")
    */
   public function findQuotation(Devis $devis)
   {
       return $this->render('document/quotation_PDF.html.twig', array(
           'devis'=> $devis
       ));
   }

   /**
    * @Route("/{facture}/findInvoice", name="research_invoice")
    */
   public function findInvoice(Facture $facture)
   {
       return $this->render('document/invoice_PDF.html.twig', array(
           'facture' => $facture,
       ));
   }

   /**
    * @Route("/{accompte}/findAdvance", name="research_advance")
    */
   public function findAdvance(Accompte $accompte)
   {
       return $this->render('document/advance_PDF.html.twig', array(
           'accompte' => $accompte,
       ));
   }

   /**
    * @Route("/{avoir}/findDebit", name="research_debit")
    */
   public function findDebit(Avoir $avoir)
   {
       return $this->render('document/debit_PDF.html.twig', array(
           'avoir' => $avoir,
       ));
   }
}
