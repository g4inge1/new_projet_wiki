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
//        return $this->render('index/index.html.twig', [
//            'controller_name' => 'IndexController',
//        ]);
        return $this->render('security/accueil_auth.html.twig', [
            'controller_name' => 'IndexController', [
            
        ]
        ]);
    }

}


