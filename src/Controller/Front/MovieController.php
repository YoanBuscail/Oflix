<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Model\Movies;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\CastingRepository;
use App\Repository\ReviewRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;


class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="app_movie_list")
     */
    public function list(GenreRepository $genreRepository, MovieRepository $movieRepository, Request $request): Response
    {
        //  findAllBySearch, requete custom du repo
        $movies = $movieRepository->findAllBySearch($request->get("search"));

        $session = $request->getSession();

        $favoris = $session->get('favoris', []);

        $genres = $genreRepository->findAll();

        return $this->render('movie/list.html.twig',[
            'movies' => $movies,
            'favoris' => $favoris,
            'genres' => $genres
        ]);
    }

    /**
     * Ci dessous dans ma route, je dis que j'attends un parametre {id} qui va correspondre à l'index du film que je veux afficher dans le tableau
     * @Route("/movie/show/{id}/{slug}", name="app_movie_show")
     */
    public function show($id, MovieRepository $movieRepository, CastingRepository $castingRepository, ReviewRepository $reviewRepository)
    {
        $movie = $movieRepository->find($id);
        // On recupere les casting d'un film en une seule requete
        $castings = $castingRepository->findAllForMovieJoinedToPersonOrderedByCreditAscDql($movie);
        $reviews = $reviewRepository->findBy(['movie' => $movie], ['watchedAt' => 'DESC']);

        if ($movie === null) {
            throw $this->createNotFoundException('Film ou série non trouvé.');
        }
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'castings' => $castings,
            'reviews'=> $reviews
        ]);
    }     
}
