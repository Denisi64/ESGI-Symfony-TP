<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route(path: '/movie/{id}', name: 'page_detail_movie')]
    public function detail(Movie $movie): Response
    {
        // Récupérer les noms des langues associées au film
//        $languages = $movie->getLanguages();
//        $languageNames = array_map(fn($language) => $language->getName(), $languages->toArray());

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
//            'languages' => $languageNames, // Passer les noms des langues au template
//            'subtitles' => $movie->getSubtitles() // Assurez-vous que les sous-titres sont également correctement envoyés
        ]);
    }



    #[Route(path: '/serie', name: 'page_detail_serie')]
    public function detailSerie(): Response
    {
        return $this->render(view: 'movie/detail_serie.html.twig');
    }
}