<?php

declare(strict_types=1);

namespace App\Controller\Other;

use App\Repository\CategorieRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class CategoryController extends AbstractController
{
    #[Route(path: '/categories', name: 'page_categories')]
    public function categories(CategorieRepository $categorieRepository, MediaRepository $mediaRepository)
    {
        $categories = $categorieRepository->findAll();
        $medias = $mediaRepository->findAll();

        return $this->render('other/discover.html.twig', [
            'categories' => $categories,
            'medias' => $medias,
        ]);    }

    #[Route(path: '/discover', name: 'page_discover')]
    public function discover(
        EntityManagerInterface $entityManager,
        CategorieRepository $categorieRepository
    ): Response {
        $categories = $categorieRepository->findAll();

        return $this->render('other/discover.html.twig', [
            'categories' => $categories,
        ]);
    }

}
