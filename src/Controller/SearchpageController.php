<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchpageController extends AbstractController
{
    #[Route('/searchpage', name: 'app_searchpage')]
    public function index(): Response
    {
        return $this->render('searchpage/index.html.twig', [
            'controller_name' => 'SearchpageController',
        ]);
    }
}
