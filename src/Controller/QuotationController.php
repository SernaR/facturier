<?php

namespace App\Controller;

use App\Entity\Accompte;
use App\Entity\Devis;
use App\Form\AccompteType;
use App\Utils\InvoiceUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("quotation")
* 
*/
class QuotationController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @Route("/validate/{id}", name="quotation_validate")
    */
    public function validation(Devis $devis,InvoiceUtils $utils)
    {
        if ( is_null($devis->getValidation()) && is_null($devis->getAnnulation())) {
    
            $validation = $devis->setValidation(new \Datetime());
            $this->em->persist($validation);

            $utils->setInvoice($this->em, $devis);
            
            $this->em->flush();
        }
        return $this->redirectToRoute('user_page');
        
    }

    /**
    * @Route("/cancel/{id}", name="quotation_cancel")
    */
    public function cancel(Devis $devis){
        
        if(!is_null($devis->getValidation()) || !is_null($devis->getAnnulation())){
            return $this->redirectToRoute('user_page');
        }
        
        $envoi = $devis->setAnnulation(new \Datetime());
        $this->em->persist($envoi);
        $this->em->flush();
        
        return $this->redirectToRoute('user_page'); 
    }
    
    /**
    * @Route("/advance/{devis}", name="invoice_advance")
    */
    public function advance(Request $request, Devis $devis, InvoiceUtils $utils)
    {
        if ( !is_null($devis->getValidation()) && is_null($devis->getAnnulation())) {

            $accompte = new Accompte();
           // $accompte->setDevis($devis);
            $devis->setAccompte($accompte);
            
            $form = $this->createForm(AccompteType::class, $accompte);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $accompte->setNumero($utils->getNumber());
                $accompte->setDate(new \Datetime());

                $this->em->persist($devis);
                $this->em->flush();
    
                return $this->redirectToRoute('research_advance', array(
                    'accompte' => $accompte->getId()
                ));
            }
    
            return $this->render('management/advance.html.twig', array(
                'devis' => $devis,
                'form'=> $form->createView(),
            ));
        }   
    }
}
