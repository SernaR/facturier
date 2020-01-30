<?php

namespace App\Utils;

class ManipulationUtils
{
  public function editQuantiy($ligne, $action, $em)
  {
    $qty = $ligne->getQuantite();
        
    if($action=="add")
        $ligne->setQuantite($qty+1);
    
    if($action=="remove" && $qty>1)
        $ligne->setQuantite($qty-1);
    
    $em->persist($ligne);
    $em->flush();
  }

}
