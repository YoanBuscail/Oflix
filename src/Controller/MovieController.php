<?php

namespace App\Controller;

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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="app_movie_list")
     */
    public function list(MovieRepository $movieRepository): Response
    {
        // On va récupérer le resultat de la requête customisé qu'on a fait sur le Movie Repository
        $movies = $movieRepository->findAllOrderByTitleAscDql();

        return $this->render('movie/list.html.twig',[
            'movies' => $movies,
        ]);
    }

    /**
     * Ci dessous dans ma route, je dis que j'attends un parametre {id} qui va correspondre à l'index du film que je veux afficher dans le tableau
     * @Route("/movie/show/{id}", name="app_movie_show")
     */
    public function show($id, MovieRepository $movieRepository, CastingRepository $castingRepository, ReviewRepository $reviewRepository)
    {
        $movie = $movieRepository->find($id);
        // On recupere les casting d'un film en une seule requete
        $castings = $castingRepository->findAllForMovieJoinedToPersonOrderedByCreditAscDql($movie);
        $reviews = $reviewRepository->findReviewsForMovie($movie);

        if ($movie === null) {
            throw $this->createNotFoundException('Film ou série non trouvé.');
        }
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'castings' => $castings,
            'reviews'=> $reviews
        ]);
    }

    /**
     * @Route("/movie/{id}/review/create", name="app_create_review")
     */
    public function createReview(Request $request, Movie $movie, ManagerRegistry $doctrine, ReviewRepository $reviewRepository): Response
    {
        // Crée une instance de la classe de formulaire
        $review = new Review();
        /* $form = $this->createForm(ReviewType::class, $review); */

        $form = $this->createFormBuilder($review)
        ->add('username', TextType::class)
        ->add('email', EmailType::class)
        ->add('content', TextareaType::class)
        ->add('rating', ChoiceType::class, [
            'choices' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ],
            'expanded' => true,
            'multiple' => false,
        ])
        ->add('reactions', ChoiceType::class, [
            'choices' => [
                'Rire' => 'Rire',
                'Pleurer' => 'Pleurer',
                'Réfléchir' => 'Réfléchir',
                'Dormir' => 'Dormir',
                'Rêver' => 'Rêver',
            ],
            'expanded' => true,
            'multiple' => true,
        ])
        ->add('watchedAt', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'dd-MM-yyyy',
            'input' => 'datetime_immutable',
        ])
        ->getForm();

        // Traite la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Associe la critique au film
            $review->setMovie($movie);

            // Enregistre la critique dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            // Redirige l'utilisateur vers la page du film après avoir ajouté la critique
            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('movie/review.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie,
        ]);
    }
    
    
}
