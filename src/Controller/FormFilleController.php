<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ActuelleFicheType;


class FormFilleController extends AbstractController
{
    #[Route('/form/fille', name: 'app_form_fille')]
    public function monAction(Request $request): Response
    {
       

        // Passez le formulaire à votre modèle Twig
        return $this->render('form_fille/index.html.twig');
    }
}
