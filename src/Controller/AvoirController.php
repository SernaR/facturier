<?php

namespace App\Controller;

use App\Entity\Avoir;
use App\Entity\LigneAvoir;
use App\Form\FactureType;
use App\Repository\AvoirRepository;
use App\Repository\FactureRepository;
use App\Utils\InvoiceUtils;
use App\Utils\ManipulationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

//todo refacto


/**
* @Route("debit")
* secu**********************************
*/
class AvoirController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     *
     * @Route("/", name="debit")
     */
    public function index(Request $request, AvoirRepository $avoirRepository, FactureRepository $factureRepository)
    {
        $avoirFound = isset($_GET['avoir']) ? $avoirRepository->find($_GET['avoir']): [];

        $form = $this->createForm(FactureType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid() && empty($avoirFound) ){
            $numero = $form['numero']->getData();
            $facture = $factureRepository->findOneBy(array('numero'=>$numero));

            if( !is_null($facture->getAvoir()) ){  
                $message = 'il existe déja un avoir sur cette facture';
            }   

            if( !$facture->getPayee() ){
                $message = 'la facture '.$facture->getNumero().' n\'est pas réglée';
            }

            if (!isset($message)) {
               $avoir = new Avoir();
                $avoir->setDate(new \Datetime());
                $avoir->setFacture($facture);
                
                foreach($facture->getLigneFacture() as $ligneFacture){

                    $ligneAvoir = new LigneAvoir();
                    $ligneAvoir->setQuantite($ligneFacture->getQuantite());
                    $ligneAvoir->setPrestation($ligneFacture->getPrestation());
                    $ligneAvoir->setAvoir($avoir); 
                    $avoir->addLigneAvoir($ligneAvoir);

                }
                
                $this->em->persist($avoir);
                $this->em->flush();   
                
                return $this->render('management/debit.html.twig', array( ///////////todo refacto
                    'avoir'=> $avoir,
                    'form'=> $form->createView(),
                    'current_menu' => 'debit',
                )); 
            } else {
                return $this->render('management/debit.html.twig', array(
                    'avoir'=> $avoirFound,
                    'message'=> $message,
                    'form'=> $form->createView(),
                    'current_menu' => 'debit',
                ));
            }
        } 
        return $this->render('management/debit.html.twig', array(
            'avoir'=> $avoirFound,
            'form'=> $form->createView(),
            'current_menu' => 'debit',
        )); 
    }

    /**
    * @Route("/removeLine/{ligneAvoir}", name="debit_removeLine")
    */
    public function removeLine(LigneAvoir $ligneAvoir)
    {
        if (is_null($ligneAvoir->getAvoir()->getNumero())){
            
            $this->em->remove($ligneAvoir);
            $this->em->flush();
    
            return $this->redirectToRoute('debit', array(
                'avoir' => $ligneAvoir->getAvoir()->getId(),
                'current_menu' => 'debit',
            ));
        }
    }

    /**
    * @Route("/serviceQty/{action}/{ligneAvoir}", name="debit_serviceQty")
    */
    public function editQuantiy(LigneAvoir $ligneAvoir, ManipulationUtils $utils, $action){
        
        if (is_null($ligneAvoir->getAvoir()->getNumero())){

            $utils->editQuantiy($ligneAvoir, $action, $this->em);
    
            return $this->redirectToRoute('debit', array(
                'avoir' => $ligneAvoir->getAvoir()->getId(),
                'current_menu' => 'debit',
            ));
        }
    }

    /**
    * @Route("/validate/{avoir}", name="debit_validate")
    */
    public function debit(Avoir $avoir, InvoiceUtils $utils){
        if( is_null($avoir->getNumero()) ){

            $avoir->setNumero($utils->getNumber($this->em));
            $this->em->persist($avoir);
            $this->em->flush();

            return $this->redirectToRoute('research_debit', array(
                'avoir' => $avoir->getId()
            ));
        }
    }

    /**
    * @Route("/cancel/{avoir}", name="debit_cancel")
    */
    public function cancel(Avoir $avoir){
        if( is_null($avoir->getNumero()) ){
            
            $this->em->remove($avoir);
            $this->em->flush();

            return $this->redirectToRoute('user_page');
        }    
    }
}
