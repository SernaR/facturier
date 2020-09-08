<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* 
* @Route("service")
*/
class ServiceController extends AbstractController
{
    private $em;
    private $prestationRepository;
    const MESSAGE =  'Enregistrement effectué';

    public function __construct(EntityManagerInterface $em, PrestationRepository $prestationRepository)
    {
        $this->em = $em;
        $this->prestationRepository = $prestationRepository;
    }

    /**
     * @Route("/", name="service")
     */
    public function index(Request $request)
    {
        $prestation = new Prestation();
        if( isset($_GET['message']) ) {
            $message = self::MESSAGE;
            return $this->getData($request, $prestation, $message);
        }
        return $this->getData($request, $prestation);
    }

    /**
    * @Route("/{id}/delete", name="service_delete")
    *
    */
    public function delete(Request $request, Prestation $prestation){
        if( is_null($prestation->getDateDeFin() )){

            $prestation->setDateDeFin(new \Datetime());
            $this->em->persist($prestation);
            $this->em->flush();
        }
        $newPrestation = new Prestation();
        return $this->getData($request, $newPrestation);  
    }
  
    /**
     * @Route("/{id}/edit", name="service_edit")
     */
    public function edit(Request $request, Prestation $prestation)
    {
        if( is_null($prestation->getDateDeFin() )){
            
            $prestation->setDateDeFin(new \Datetime());
            $this->em->persist($prestation);

            $update = new Prestation();
            $update->setCode($prestation->getCode());
            $update->setLibelle($prestation->getLibelle());
            $update->setDescription($prestation->getDescription());
            $update->setMontant($prestation->getMontant());
            $update->setType($prestation->getType());

            return $this->getData($request, $update);
        }  
    }
  
    /**
     * @Route("/{id}/duplicate", name="service_duplicate")
     */
    public function duplicate(Request $request, Prestation $prestation)
    {
        if(is_null($prestation->getDateDeFin())){

            $duplicate = new Prestation();
            $duplicate->setCode($prestation->getCode()." (copie)");
            $duplicate->setLibelle($prestation->getLibelle()." (copie)");
            $duplicate->setDescription($prestation->getDescription());
            $duplicate->setMontant($prestation->getMontant());
            $duplicate->setType($prestation->getType());

            return $this->getData($request, $duplicate);
        }  
    }
  
    public function getData($request, $prestation, $message = null){

        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        $form2 = $this->createFormBuilder()
        ->add('Libelle',TextType::class, array())
        ->getForm();
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($prestation);
            $this->em->flush();

            return $this->redirectToRoute('service', ['message' => true]);
        }

        if($form2->isSubmitted() && $form2->isValid()){
            $libelle = $form2['Libelle']->getData();
            $prestations = $this->prestationRepository->findService($libelle);
            return $this->render('user/service.html.twig', array(
                'prestations' => $prestations,
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'current_menu'=>'service',
            ));
        }

        return $this->render('user/service.html.twig', array(
            'prestations' => [],
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'current_menu'=>'service',
            'message' => $message
        ));
    }
}
