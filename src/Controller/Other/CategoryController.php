<?php

declare(strict_types=1);

namespace App\Controller\Other;

use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class CategoryController extends AbstractController
{
    #[Route(path: '/categories', name: 'page_categories')]
    public function categories()
    {
        return $this->render('other/discover.html.twig');
    }

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
