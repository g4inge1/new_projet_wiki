<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ActuelleFiche;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    

//    #[Route('/new', name: 'app_index', methods: ['GET'])]
//public function new(): Response
//{
//    $actuelleFiche = new ActuelleFiche();
//    $form = $this->createForm(ActuelleFicheType::class, $actuelleFiche);
//
//    return $this->render('index/index.html.twig', [
//        'form' => $form->createView(),
//    ]);
//}


}


