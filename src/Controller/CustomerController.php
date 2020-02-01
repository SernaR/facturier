<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("customer")
 * 
 */
class CustomerController extends AbstractController
{
    const MESSAGE =  'Enregistrement effectué';

    /**
     * @Route("/", name="customer")
     */
    public function index(Request $request, ClientRepository $clientRepository)
    {
        $client = new Client();
        if( isset($_GET['message']) ) {
            $message = self::MESSAGE;
            return $this->getData($request, $client, $clientRepository, $message);
        }
        return $this->getData($request, $client, $clientRepository);
    }

    /** 
     * @Route("/edit/{id}", name="customer_edit")
     */
    public function edit(Request $request, Client $client, ClientRepository $clientRepository)
    {
        return $this->getData($request, $client, $clientRepository);
        
    }
    
    public function getData($request, $client, $clientRepository, $message = ''){
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        
        $form2 = $this->createFormBuilder()
        ->add('Nom',TextType::class, array())
        ->getForm();
        $form2->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            
            if(isset($_GET['update'])){
                return $this->redirectToRoute('customer', array('message' => true) );
            }else{
                return $this->redirectToRoute('creation_quotation', array(
                    'client' => $client->getId(),
                ));
            }
        }
        
        if($form2->isSubmitted() && $form2->isValid()){
            $nom = $form2['Nom']->getData();
            $clientFound = $clientRepository->findCustomer($nom);
            
            return $this->render('user/customer.html.twig', array(
                'clients' => $clientFound,
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'current_menu'=>'customer',
            ));
        }
        
        return $this->render('user/customer.html.twig', array(
            'clients' => [],
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'current_menu'=>'customer',
            'message' => $message
        ));
    }
}
