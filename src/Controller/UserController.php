<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeNoRoles;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $newUser = $request->query->get('newUser', false);

        $user = new User();
        // Utilisation du formulaire approprié en fonction de $newUser
        $form = $newUser ? $this->createForm(UserType::class, $user) : $this->createForm(UserTypeNoRoles::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le mot de passe en clair depuis le formulaire
            $plainPassword = $form->get('password')->getData();

            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

            // Définir le mot de passe haché pour l'utilisateur
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            if ($newUser) {
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
            // Rediriger en fonction de la logique de votre application
            return $this->redirectToRoute('app_actuelle_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($newUser) {
            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }

        return $this->render('security/sign_up.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher, $newUser = false): Response
    {

        if ($newUser) {
            $form = $this->createForm(UserTypeNoRoles::class, $user);
            $form->handleRequest($request);
        } else {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();

            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

            // Définir le mot de passe haché pour l'utilisateur
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

}
