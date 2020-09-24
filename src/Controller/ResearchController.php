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
use Symfony\Component\Serializer\SerializerInterface;

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
   public function index(Request $request){

       $form = $this->createForm(GetClientType::class);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           
           $name =  $form['nom']->getData() === null ? 'all':  $form['nom']->getData();
           return $this->redirectToRoute('research_customers', array(
              'name' => $name
           ));
       }
       
       return $this->render('management/research.html.twig', array(
           'clients' => [],
           'form' => $form->createView(),
           'current_menu'=>'research',
       ));
   }

   /**
    * @Route("/customers/{name}", name="research_customers")
    */
   public function customersDocuments(ClientRepository $clientRepository, $name)
   {
        $clientFound = $clientRepository->findCustomers($name);
        return $this->render('management/research.html.twig', array( 
            'clients' => $clientFound,
            'current_menu'=>'research',
        ));
   }

   /**
    * @Route("/findQuotation/{devis}", name="research_quotation")
    */
   public function findQuotation(Devis $devis, SerializerInterface $serializer)
   {
        $json = $serializer->serialize($devis, 'json', ['groups' => 'quotation']);
        return $this->render('document/quotation.html.twig', array(    
           'devis'=> $devis,
           'json' => $json
       ));
   }

   /**
    * @Route("/findInvoice/{facture}", name="research_invoice")
    */
   public function findInvoice(Facture $facture, SerializerInterface $serializer)
   {
        $json = $serializer->serialize($facture, 'json', ['groups' => 'invoice']);
        return $this->render('document/invoice.html.twig', array(
            'facture' => $facture,
            'json' => $json
        ));
   }

   /**
    * @Route("/findAdvance/{accompte}", name="research_advance")
    */
   public function findAdvance(Accompte $accompte, SerializerInterface $serializer)
   {
        $json = $serializer->serialize($accompte, 'json', ['groups' => 'advance']);
        return $this->render('document/advance.html.twig', array(
            'accompte' => $accompte,
            'json' => $json
        ));
   }

   /**
    * @Route("/findDebit/{avoir}", name="research_debit")
    */
   public function findDebit(Avoir $avoir, SerializerInterface $serializer)
   {
        $json = $serializer->serialize($avoir, 'json', ['groups' => 'debit']);
       return $this->render('document/debit.html.twig', array(
           'avoir' => $avoir,
           'json' => $json
       ));
   }
}
