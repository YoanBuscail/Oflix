<?php

namespace App\Controller\Api;

use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends AbstractController
{
    /**
     * @Route("/api/movies", name="app_api_list", methods={"GET"})
     */
    public function list(MovieRepository $movieRepository): JsonResponse
    {
        //  récupérer les films
        $movies = $movieRepository->findAll();

        // on retour les films en json
        return $this->json($movies, Response::HTTP_OK, [],["groups" => "movies"]);
    }

    /**
     * @Route("/api/genres/{genreId}/movies", name="app_api_genre_movies", methods={"GET"})
     */
    public function moviesByGenre(GenreRepository $genreRepository, MovieRepository $movieRepository, int $genreId): JsonResponse
    {
        // Récupérer le genre spécifié par son ID
        $genre = $genreRepository->find($genreId);

        if (!$genre) {
            return $this->json(['message' => 'Genre not found'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer les films qui ont le genre spécifié
        $movies = $movieRepository->findByGenre($genre);

        if (empty($movies)) {
            return $this->json(['message' => 'Pas de film pour ce genre'], Response::HTTP_NOT_FOUND);
        }

        // Retourner les films en JSON avec les genres inclus
        return $this->json($movies, Response::HTTP_OK, [], ["groups" => "movies"]);
    }

    /**
     * @Route("/api/movies/random", name="app_api_random_movie", methods={"GET"})
     */
    public function randomMovie(MovieRepository $movieRepository): JsonResponse
    {
        // Récupérez tous les films
        $movies = $movieRepository->findAll();

        // Sélectionnez un film au hasard
        $randomMovie = $movies[array_rand($movies)];

        // Retournez le film au hasard en JSON
        return $this->json($randomMovie, Response::HTTP_OK, [], ["groups" => "movies"]);
    }
}
