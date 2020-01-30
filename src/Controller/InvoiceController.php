<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\LigneFacture;
use App\Entity\Prestation;
use App\Entity\TypeDeService;
use App\Form\InvoiceType;
use App\Repository\PrestationRepository;
use App\Utils\InvoiceUtils;
use App\Utils\ManipulationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*/
* @Route("invoice")
* secu///////////////////////////
*/
class InvoiceController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     *
     * @Route("/index/{facture}/{type}", name="invoice", defaults={ "type": 1 })
     */
    public function index(Facture $facture, TypeDeService $type, PrestationRepository $prestationRepository)
    {
        if (!is_null($facture->getValidation())) {
            return $this->redirectToRoute('user_page');
        }

        return $this->render('management/invoice.html.twig', array(
            'facture' => $facture,
            'prestations'=>$prestationRepository->findBy(array('dateDeFin'=>null, 'type'=>$type), array('code' => 'ASC')),
            'focus' => $type->getId(),
        ));
    }

    /**
    * @Route("/addLine/{facture}/{prestation}", name="invoice_addLine")
    */
    public function addLine(Facture $facture, Prestation $prestation){
        if (is_null($facture->getValidation())){

            $ligneFacture = new LigneFacture();
            $ligneFacture->setPrestation($prestation);
            $ligneFacture->setFacture($facture);
    
            $this->em->persist($ligneFacture);
            $this->em->flush();
    
            return $this->redirectToRoute('invoice', array(
                'facture' => $facture->getId(),
                'type'=>$prestation->getType()->getId(),
            ));
        }    
    }

    /**
    * @Route("/removeLine/{ligneFacture}", name="invoice_removeLine")
    */
    public function removeLine(LigneFacture $ligneFacture)
    {
        if (is_null($ligneFacture->getFacture()->getValidation())){
            $this->em->remove($ligneFacture);
            $this->em->flush();
    
            return $this->redirectToRoute('invoice', array(
                'facture' => $ligneFacture->getFacture()->getId(),
                'type'=> $ligneFacture->getPrestation()->getType()->getId(),
            ));
        }
    }

   /**
    * @Route("/validate/{facture}", name="invoice_validate")
    */
    public function validate(Request $request, Facture $facture, InvoiceUtils $utils)
    {
        if (is_null($facture->getLivraison()) && is_null($facture->getValidation())) {
            
            $form = $this->createForm(InvoiceType::class, $facture);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $facture->setValidation(new \Datetime());
                $facture->setNumero($utils->getNumber());

                $this->em->persist($facture);
                $this->em->flush();
                
                return $this->redirectToRoute('research_invoice', array(
                    'facture' => $facture->getId()
                ));
            }
    
            return $this->render('management/livraison.html.twig', array(
                'facture' => $facture,
                'form'=> $form->createView(),
            ));
        }  
    }

    /**
    * @Route("/sold/{facture}", name="invoice_sold")
    */
    public function sold(Facture $facture){

        if( !is_null($facture->getPayee()) ){

            $facture->setPayee(true);
            $this->em->persist($facture);
            $this->em->flush();
    
            return $this->redirectToRoute('user_page');
        }    
    }

    /**
    * @Route("/serviceQty/{action}/{ligneFacture}", name="invoice_serviceQty")
    */
    public function editQuantiyAction(LigneFacture $ligneFacture, ManipulationUtils $utils, $action)
    {     
        if (is_null($ligneFacture->getFacture()->getValidation())){
            $utils->editQuantiy($ligneFacture, $action, $this->em);
    
            return $this->redirectToRoute('invoice', array(
                'facture' => $ligneFacture->getFacture()->getId(),
                'type'=>$ligneFacture->getPrestation()->getType()->getId(),
            ));
        }
    }
}
