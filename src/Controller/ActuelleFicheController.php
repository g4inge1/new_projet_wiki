<?php

namespace App\Controller;

use App\Entity\ActuelleFiche;
use App\Form\ActuelleFicheType;
use App\Repository\ActuelleFicheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/actuelle/fiche')]
class ActuelleFicheController extends AbstractController
{
    #[Route('/', name: 'app_actuelle_fiche_index', methods: ['GET'])]

    public function index(Request $request, ActuelleFicheRepository $actuelleFicheRepository): Response
    {
        // Récupérer les paramètres de filtrage de la requête
        $search = $request->query->get('search');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $category = $request->query->get('category');
        $sortField = $request->query->get('sort', 'dateCreation');
        $sortOrder = $request->query->get('order', 'DESC'); 
    
        // Utiliser ces paramètres pour filtrer les données depuis la base de données
        if ($search || $startDate || $endDate || $category || $sortField || $sortOrder) {
            $actuelleFiches = $actuelleFicheRepository->findByFilters($search, $startDate, $endDate, $category, $sortField, $sortOrder);
        } else {
            // Utiliser findAll() si aucun paramètre de filtrage n'est présent
            $actuelleFiches = $actuelleFicheRepository->findAll();
        }
    
        // Rendre la vue avec les paramètres de filtre
        return $this->render('actuelle_fiche/index.html.twig', [
            'actuelle_fiches' => $actuelleFiches,
            'search' => $search ?? '',
            'startDate' => $startDate ?? '',
            'endDate' => $endDate ?? '',
            'category' => $category ?? '',
        ]);
    }


    #[Route('/new', name: 'app_actuelle_fiche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $actuelleFiche = new ActuelleFiche();
        $form = $this->createForm(ActuelleFicheType::class, $actuelleFiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actuelleFiche);
            $entityManager->flush();

            return $this->redirectToRoute('app_actuelle_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actuelle_fiche/new.html.twig', [
            'actuelle_fiche' => $actuelleFiche,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actuelle_fiche_show', methods: ['GET'])]
    public function show(ActuelleFiche $actuelleFiche): Response
    {
        return $this->render('actuelle_fiche/show.html.twig', [
            'actuelle_fiche' => $actuelleFiche,
        ]);
        
    }

    #[Route('/{id}/edit', name: 'app_actuelle_fiche_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActuelleFiche $actuelleFiche, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActuelleFicheType::class, $actuelleFiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_actuelle_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actuelle_fiche/edit.html.twig', [
            'actuelle_fiche' => $actuelleFiche,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actuelle_fiche_delete', methods: ['POST'])]
    public function delete(Request $request, ActuelleFiche $actuelleFiche, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actuelleFiche->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuelleFiche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_actuelle_fiche_index', [], Response::HTTP_SEE_OTHER);
    }
    

}

