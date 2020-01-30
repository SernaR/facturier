<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\LigneDevis;
use App\Entity\Prestation;
use App\Entity\TypeDeService;
use App\Form\GetClientType;
use App\Repository\ClientRepository;
use App\Repository\PrestationRepository;
use App\Utils\InvoiceUtils;
use App\Utils\ManipulationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("creation")
* secu******************************
* 
*/
class CreationController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @Route("/customer", name="creation_getCustomer")
    */
    public function getCustomer(Request $request, ClientRepository $clientRepository){
    
        $form = $this->createForm(GetClientType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $nom = $form['nom']->getData();
            $clientFound = $clientRepository->findCustomer($nom);
            
            return $this->render('management/creation_get_customer.html.twig', array(
                'clients' => $clientFound,
                'form' => $form->createView(),
                'current_menu'=>'creation',
            ));
        }
        
        return $this->render('management/creation_get_customer.html.twig', array(
            'clients' => [],
            'form' => $form->createView(),
            'current_menu'=>'creation',
            
        ));
    }

    /**
    * @Route("/quotation/{client}", name="creation_quotation")
    */
    public function createQuotation(Client $client){

        $devis = new Devis();
        $devis->setClient($client);
        $this->em->persist($devis);
        $this->em->flush();

        return $this->redirectToRoute('management/creation', array(
            'devis' => $devis->getId(),
        ));
    }

    /**
    * @Route("/index/{devis}/{type}", name="creation", defaults={ "type": 1 })
    */
    public function index(Devis $devis, TypeDeService $type, PrestationRepository $prestationRepository){
        
        if ( is_null($devis->getEnvoi() )){
            $prestations = $prestationRepository->findBy(array('dateDeFin'=>null, 'type'=>$type), array('code' => 'ASC'));
            
            return $this->render('management/creation.html.twig', array(
                'devis' => $devis,
                'prestations'=> $prestations,
                'current_menu'=> 'creation',
                'focus' => $type->getId(),
            ));
        }
    }

    
    /**
    * @Route("/discount/{prestation}/{devis}", name="creation_discount")
    */
    public function discount(Prestation $prestation, Devis $devis){
        if ( is_null($devis->getEnvoi() )){
            
            $discount = $prestation->getMontant();
            $devis->setDiscount($discount);
            $this->em->persist($devis);
            $this->em->flush();
            
            return $this->redirectToRoute('creation',array(
                'devis' => $devis->getId(),
                'type'=> $prestation->getType()->getId(),
            ));
        }
    }

    /**
    * @Route("/validate/{devis}", name="creation_validate")
    */
    public function validation( Devis $devis) 
    {
        if ( is_null($devis->getEnvoi() )){

            $devis->setEnvoi(new \Datetime());
            $this->em->persist($devis);       
            $this->em->flush();
    
            return $this->redirectToRoute('research_quotation', array( 
                'devis'=> $devis->getId()
            )); 
        } 
    }
    
    /**
    * @Route("/invoice/validate{devis}", name="creation_invoice")
    */
    public function invoiceValidation(Devis $devis, InvoiceUtils $utils) 
    {
        $facture = $utils->setInvoice($this->em, $devis); 
        //remove ligne devis
        $this->em->flush();

        return $this->redirectToRoute('invoice_validate', array(
            'facture' => $facture->getId()
        ));
    }

    /**
     * @Route("/addLine/{prestation}/{devis}", name="creation_addLine")
     */
    public function addLine(Prestation $prestation, Devis $devis){

        $lignedevis = new LigneDevis();
        $lignedevis->setPrestation($prestation);
        $lignedevis->setDevis($devis);
        $devis->addLigneDevi($lignedevis);
        
        $this->em->persist($devis);
        $this->em->flush();

        return $this->redirectToRoute( 'creation', array(
            'type' => $prestation->getType()->getId(),
            'devis' => $devis->getId()
        ));
    }

    /**
    * @Route("/removeLine/{ligneDevis}", name="creation_removeLine")
    */
    public function removeLine(LigneDevis $ligneDevis){ 

        if ( is_null($ligneDevis->getDevis()->getEnvoi() )){

            $this->em->remove($ligneDevis);
            $this->em->flush();
            
            return $this->redirectToRoute('creation', array(
                'type' => $ligneDevis->getPrestation()->getType()->getId(),
                'devis' => $ligneDevis->getDevis()->getId(),
            ));
        } 
    }

    /**
    * @Route("/serviceQty/{ligneDevis}/{action}", name="creation_serviceQty")
    */
    public function editQuantiy(LigneDevis $ligneDevis, ManipulationUtils $utils, $action)
    {
        if ( is_null($ligneDevis->getDevis()->getEnvoi() )){
    
            $utils->editQuantiy($ligneDevis, $action, $this->em); 
            
            return $this->redirectToRoute('creation', array(
                'type'=>$ligneDevis->getPrestation()->getType()->getId(),
                'devis' => $ligneDevis->getDevis()->getId()
            ));  
        }      
    }
}
