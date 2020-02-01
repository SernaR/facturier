<?php

namespace App\Utils;

use App\Entity\Facture;
use App\Entity\LigneFacture;
use App\Repository\AccompteRepository;
use App\Repository\AvoirRepository;
use App\Repository\FactureRepository;

//GetInvoiceNumber

class InvoiceUtils
{
  private $factureRepository;
  private $accompteRepository;
  private $avoirRepository;
    
    public function __construct(AccompteRepository $accompteRepository, FactureRepository $factureRepository, AvoirRepository $avoirRepository)
    {
        $this->factureRepository = $factureRepository;
        $this->accompteRepository = $accompteRepository;
        $this->avoirRepository = $avoirRepository;
    }
  
  /**
   * Calculate invoice number
   * @return String
   */
  public function getNumber()
  {
    $AdvanceCount = $this->accompteRepository->findAdvanceCount();
    $InvoiceCount = $this->factureRepository->findInvoiceCount();
    $debitCount = $this->avoirRepository->findDebitCount();
    $increment = 10;

    return 'F'.str_pad( $AdvanceCount +  $InvoiceCount +  $increment +  $debitCount, 4, "0", STR_PAD_LEFT );
  }

  public function setInvoice($em, $devis){
    $facture = new Facture();
    $devis->setFacture($facture);

    $facture->setDate(new \Datetime());
    //$facture->setDevis($devis);
    
    foreach( $devis-> getLigneDevis() as $ligne ){    
        $ligneFacture = new LigneFacture();
        
        $ligneFacture->setQuantite($ligne->getQuantite());
        $ligneFacture->setPrestation($ligne->getPrestation());
        $facture->addLigneFacture($ligneFacture);

        $em->persist($ligneFacture); //cascade persist KO ??
      }
    
    $em->persist($facture);  //cascade persist KO ??
    $em->persist($devis);       
    return $facture;

  }
}