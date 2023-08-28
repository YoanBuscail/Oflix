<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends AbstractController
{
    /**
     * Ajout d'une critique sur un film
     * @Route("/movie/{id}/review/add", name="app_movie_review_add")
     */
    public function add(Movie $movie, Request $request, ReviewRepository $reviewRepository): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);

        // Ici on récup le contenu de la requete
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            


            // On associe la review au film concerné
            $review->setMovie($movie);
            // On ajoute $review en bdd grace au reviewRepository
            $reviewRepository->add($review, true);
            // Maintenant on peut rediriger vers la page de detail du film
            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }


        return $this->renderForm('review/add.html.twig', [
            // pour afficher le titre du film, on doit passer par l'objet $movie
            'movie' => $movie,
            // pour afficher le formulaire
            'form' => $form
        ]);
    }
}
