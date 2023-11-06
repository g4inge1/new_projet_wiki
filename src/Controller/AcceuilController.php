<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(): Response
    {
        // Dans un contrôleur Symfony ou une commande, vous pouvez faire quelque chose comme ça :

$entityManager = $this->getDoctrine()->getManager();
$connection = $entityManager->getConnection();
$schemaManager = $connection->getSchemaManager();

$tables = $schemaManager->listTables();

foreach ($tables as $table) {
    echo "Table: " . $table->getName() . PHP_EOL;
}

        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}




