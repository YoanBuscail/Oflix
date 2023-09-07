<?php

namespace App\Controller\Api;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends AbstractController
{
    /**
     * @Route("/api/genres", name="app_api_genre_list", methods={"GET"})
     */
    public function list(GenreRepository $genreRepository): JsonResponse
    {
        //  récupérer les films
        $genres = $genreRepository->findAll();

        // on retour les films en json
        return $this->json($genres, Response::HTTP_OK, [],["groups" => "genres"]);
    }
}
