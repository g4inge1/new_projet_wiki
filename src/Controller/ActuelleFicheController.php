<?php

namespace App\Controller;

use App\Repository\CommentairesRepository;
use App\Entity\Categorie;
use App\Entity\ActuelleFiche;
use App\Form\CategorieType;
use App\Form\ActuelleFicheType;
use App\Repository\ActuelleFicheRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/actuelle/fiche')]
class ActuelleFicheController extends AbstractController
{
    #[Route('/', name: 'app_actuelle_fiche_index', methods: ['GET'])]
    public function index(Request $request, ActuelleFicheRepository $actuelleFicheRepository, CategorieRepository $actuelleCategorieRepository): Response
    {
        // Récupérer les paramètres de filtrage de la requête
        $search    = $request->query->get('search');
        $startDate = $request->query->get('startDate');
        $endDate   = $request->query->get('endDate');
        $category  = $request->query->get('category');
        $sortField = $request->query->get('sort', 'dateCreation');
        $sortOrder = $request->query->get('order', 'DESC');

        $actuelleCategories = $actuelleCategorieRepository->findAll();


        // Utiliser ces paramètres pour filtrer les données depuis la base de données
        if ($search || $startDate || $endDate || $category || $sortField || $sortOrder) {
            $actuelleFiches = $actuelleFicheRepository->findByFilters($search, $startDate, $endDate, $category, $sortField, $sortOrder);
        } else {
            // Utiliser findAll() si aucun paramètre de filtrage n'est présent
            $actuelleFiches = $actuelleFicheRepository->findAll();
        }

        // Rendre la vue avec les paramètres de filtre
        return $this->render('actuelle_fiche/index.html.twig', [
            'actuelle_fiches'     => $actuelleFiches,
            'search'              => $search ?? '',
            'startDate'           => $startDate ?? '',
            'endDate'             => $endDate ?? '',
            'category'            => $category ?? '',
            'actuelle_categories' => $actuelleCategories
        ]);
    }


    #[Route('/new', name: 'app_actuelle_fiche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategorieRepository $actuelleCategorieRepository): Response
    {

        $actuelleFiche      = new ActuelleFiche();
        $actuelleCategories = $actuelleCategorieRepository->findAll();

        $form = $this->createForm(ActuelleFicheType::class, $actuelleFiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actuelleFiche);
            $entityManager->flush();

            return $this->redirectToRoute('app_actuelle_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actuelle_fiche/new.html.twig', [
            'actuelle_fiche'      => $actuelleFiche,
            'form'                => $form,
            'actuelle_categories' => $actuelleCategories

        ]);
    }

    #[Route('/{id}', name: 'app_actuelle_fiche_show', methods: ['GET'])]
    public function show(ActuelleFiche $actuelleFiche, CommentairesRepository $commentairesRepository, CategorieRepository $categorieRepository): Response
    {
        $categorieId = $actuelleFiche->getIdCategories();
        $commentaires = $commentairesRepository->findByFicheId($actuelleFiche->getId());

        $categorie = null;  // Initialisez la variable en dehors du bloc if

        if ($categorieId !== null && $categorieId != 0) {
            $categorie = $categorieRepository->find($categorieId);
        }

        return $this->render('actuelle_fiche/show.html.twig', [
            'actuelle_fiche' => $actuelleFiche,
            'commentaires'   => $commentaires,
            'categorie'      => $categorie,
        ]);
    }


    #[Route('/{id}', name: 'app_actuelle_fiche_delete', methods: ['POST'])]
    public function delete(Request $request, ActuelleFiche $actuelleFiche, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actuelleFiche->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuelleFiche);
            $entityManager->flush();
            $this->addFlash('success', 'La fiche a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_actuelle_fiche_index');
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
            'form'           => $form,
        ]);
    }


}
