<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    #[Route(path: '/Categorie/{id}', name: 'page_Categorie')]
    public function Categorie(
        Categorie $Categorie
    ): Response
    {
        return $this->render('movie/Categorie.html.twig', [
            'Categorie' => $Categorie
        ]);
    }

    #[Route(path: '/discover', name: 'page_discover')]
    public function discover(
        EntityManagerInterface $entityManager,
        CategorieRepository $CategorieRepository,
    ): Response
    {
        $categories = $CategorieRepository->findAll();

        return $this->render('movie/discover.html.twig', [
            'categories' => $categories
        ]);
    }
}